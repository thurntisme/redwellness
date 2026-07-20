<?php
$userId = $_SESSION['user_id'] ?? 0;
$userName = $_SESSION['user_name'] ?? 'Guest';

$date = date('l, F j');
$hour = (int)date('G');
if ($hour < 12) {
    $greeting = 'Good morning';
} elseif ($hour < 18) {
    $greeting = 'Good afternoon';
} else {
    $greeting = 'Good evening';
}

// ── Nutrition ──────────────────────────────────────────────────────────
$caloriesConsumed = 0;
$calorieGoal = 2500;
$proteinGoal = 150;
$carbsGoal = 250;
$fatsGoal = 65;

if ($userId) {
    $nutStmt = $pdo->prepare("SELECT COALESCE(SUM(calories),0) as total_calories, COALESCE(SUM(protein),0) as total_protein, COALESCE(SUM(carbs),0) as total_carbs, COALESCE(SUM(fats),0) as total_fats FROM nutrition_logs WHERE user_id = ? AND date(logged_at) = date('now')");
    $nutStmt->execute([$userId]);
    $nutrition = $nutStmt->fetch();

    $goalStmt = $pdo->prepare("SELECT calorie_goal, protein_goal, carbs_goal, fats_goal FROM user_nutrition_goals WHERE user_id = ?");
    $goalStmt->execute([$userId]);
    $goals = $goalStmt->fetch();
    if ($goals) {
        $calorieGoal = (int) $goals['calorie_goal'];
        $proteinGoal = (int) $goals['protein_goal'];
        $carbsGoal = (int) $goals['carbs_goal'];
        $fatsGoal = (int) $goals['fats_goal'];
    }

    $caloriesConsumed = (int) $nutrition['total_calories'];
}
$caloriesLeft = max(0, $calorieGoal - $caloriesConsumed);
$caloriesPercent = $calorieGoal > 0 ? round($caloriesConsumed / $calorieGoal * 100) : 0;

// ── Water ──────────────────────────────────────────────────────────────
$waterCurrent = 0;
$waterGoal = 2.5;
if ($userId) {
    $gStmt = $pdo->prepare("SELECT water_goal_ml FROM user_goals WHERE user_id = ?");
    $gStmt->execute([$userId]);
    $g = $gStmt->fetch();
    $waterGoal = $g ? round((int) $g['water_goal_ml'] / 1000, 1) : 2.5;

    $waterStmt = $pdo->prepare("SELECT COALESCE(SUM(amount),0) as total_ml FROM water_logs WHERE user_id = ? AND date(logged_at) = date('now')");
    $waterStmt->execute([$userId]);
    $waterData = $waterStmt->fetch();
    $waterCurrent = round((int) $waterData['total_ml'] / 1000, 1);
}
$waterPercent = $waterGoal > 0 ? round($waterCurrent / $waterGoal * 100) : 0;

// ── Today's Exercises ──────────────────────────────────────────────────
$dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
$todayDay = $dayNames[(int)date('w')];

$todayExercises = [];
$loggedIds = [];
if ($userId) {
    $planStmt = $pdo->prepare("
        SELECT w.id, w.exercise_id, w.sets, w.reps, e.name, e.category
        FROM workouts w
        JOIN exercises e ON e.id = w.exercise_id
        WHERE w.user_id = ? AND w.day_of_week = ? AND w.is_morning_routine = 0
        ORDER BY w.id
    ");
    $planStmt->execute([$userId, $todayDay]);
    $todayExercises = $planStmt->fetchAll();

    $logStmt = $pdo->prepare("SELECT exercise_id FROM workout_logs WHERE user_id = ? AND date(logged_at) = date('now')");
    $logStmt->execute([$userId]);
    $loggedIds = $logStmt->fetchAll(PDO::FETCH_COLUMN);
}
$loggedSet = array_flip($loggedIds);

// ── Chart Data ─────────────────────────────────────────────────────────
$chartDays = [];
$chartNutrition = [];
$chartWater = [];
$chartWorkout = [];

for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-{$i} days"));
    $chartDays[] = date('D', strtotime($d));

    $nutStmt = $pdo->prepare("SELECT COALESCE(SUM(calories),0) FROM nutrition_logs WHERE user_id = ? AND date(logged_at) = ?");
    $nutStmt->execute([$userId, $d]);
    $chartNutrition[] = (int) $nutStmt->fetchColumn();

    $waterStmt = $pdo->prepare("SELECT COALESCE(SUM(amount),0) FROM water_logs WHERE user_id = ? AND date(logged_at) = ?");
    $waterStmt->execute([$userId, $d]);
    $chartWater[] = round((int) $waterStmt->fetchColumn() / 1000, 1);

    $workStmt = $pdo->prepare("SELECT COALESCE(SUM(duration_minutes),0) FROM workout_logs WHERE user_id = ? AND date(logged_at) = ?");
    $workStmt->execute([$userId, $d]);
    $chartWorkout[] = (int) $workStmt->fetchColumn();
}

require __DIR__ . '/partials/header.php';
?>

        <!-- Hero Greeting -->
        <section class="mb-lg">
            <p class="font-label-caps text-label-caps text-secondary mb-base"><?= strtoupper(date('l, F j')) ?></p>
            <h1 class="font-headline-lg-mobile text-headline-lg-mobile"><?= htmlspecialchars($greeting) ?>, <?= htmlspecialchars($userName) ?>.</h1>
            <p class="font-body-sm text-on-surface-variant">Your energy levels are looking high today. Ready to crush it?</p>
        </section>

        <!-- Bento Grid for Progress Rings -->
        <section class="grid grid-cols-2 gap-sm mb-lg">
            <!-- Daily Workout - Large Feature -->
            <div class="col-span-2 bg-surface-container-lowest border border-surface-variant p-md rounded-xl shadow-sm">
                <h3 class="font-label-caps text-label-caps text-secondary uppercase mb-sm">LAST 7 DAYS PROGRESS</h3>
                <div class="w-full rounded-lg overflow-hidden relative">
                    <canvas class="w-full h-48" id="progressChart"></canvas>
                </div>
            </div>

            <!-- Calories -->
            <div class="bg-surface-container-lowest border border-surface-variant p-sm rounded-xl shadow-sm">
                <h3 class="font-label-caps text-label-caps text-secondary">NUTRITION</h3>
                <div class="mt-sm flex flex-col items-center">
                    <div class="relative w-20 h-20 mb-sm">
                        <svg class="w-full h-full">
                            <circle class="text-tertiary/10" cx="40" cy="40" fill="transparent" r="32" stroke="currentColor" stroke-width="8"></circle>
                            <circle id="nut-ring" class="text-tertiary progress-ring-circle" cx="40" cy="40" fill="transparent" r="32" stroke="currentColor" stroke-dasharray="201" stroke-dashoffset="201" stroke-linecap="round" stroke-width="8"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <p class="font-label-caps text-label-caps"><?= $caloriesPercent ?>%</p>
                        </div>
                    </div>
                    <p class="font-headline-md text-headline-md"><?= number_format($caloriesLeft) ?></p>
                    <p class="font-body-sm text-on-surface-variant">kcal left</p>
                </div>
                <a href="<?= url('nutrition') ?>" class="mt-sm w-full py-1 bg-primary-container text-on-primary-container font-label-caps text-[10px] rounded-full shadow-sm active:scale-95 transition-all flex items-center justify-center gap-1"><span class="material-symbols-outlined text-[14px]">add</span>LOG MEAL</a>
            </div>

            <!-- Water -->
            <div class="bg-surface-container-lowest border border-surface-variant p-sm rounded-xl shadow-sm">
                <h3 class="font-label-caps text-label-caps text-secondary">WATER</h3>
                <div class="mt-sm flex flex-col items-center">
                    <div class="relative w-20 h-20 mb-sm">
                        <svg class="w-full h-full">
                            <circle class="text-primary-container/20" cx="40" cy="40" fill="transparent" r="32" stroke="currentColor" stroke-width="8"></circle>
                            <circle id="water-ring" class="text-primary-container progress-ring-circle" cx="40" cy="40" fill="transparent" r="32" stroke="currentColor" stroke-dasharray="201" stroke-dashoffset="201" stroke-linecap="round" stroke-width="8"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">water_drop</span>
                        </div>
                    </div>
                    <p class="font-headline-md text-headline-md"><?= $waterCurrent ?>L</p>
                    <p class="font-body-sm text-on-surface-variant">Goal: <?= $waterGoal ?>L</p>
                </div>
                <a href="<?= url('water') ?>" class="mt-sm w-full py-1 bg-primary-container text-on-primary-container font-label-caps text-[10px] rounded-full shadow-sm active:scale-95 transition-all flex items-center justify-center gap-1"><span class="material-symbols-outlined text-[14px]">add</span>LOG WATER</a>
            </div>
        </section>

        <!-- Today's Exercises -->
        <?php if ($todayExercises): ?>
        <section class="mb-lg">
            <div class="bg-primary-container text-on-primary-container p-sm rounded-xl mb-sm shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">event_note</span>
                    <h2 class="font-label-caps text-label-caps uppercase tracking-wider">your workout today</h2>
                </div>
                <span class="material-symbols-outlined opacity-80">info</span>
            </div>
            <div class="flex flex-col gap-sm">
                <?php foreach ($todayExercises as $ex): $completed = isset($loggedSet[$ex['exercise_id']]); ?>
                <a href="<?= url('exercise') ?>?id=<?= $ex['exercise_id'] ?>" class="bg-surface-container-lowest border border-surface-variant rounded-xl p-sm flex items-center gap-sm transition-transform active:scale-[0.98] <?= $completed ? 'opacity-80' : '' ?> no-underline text-on-surface">
                    <div class="relative w-16 h-16 rounded-lg bg-surface-container flex items-center justify-center shrink-0 overflow-hidden">
                        <span class="material-symbols-outlined text-primary text-[28px]">fitness_center</span>
                        <?php if ($completed): ?>
                        <div class="absolute inset-0 bg-tertiary/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-tertiary bg-tertiary rounded-full p-0.5 text-[16px]">check</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-label-caps text-label-caps <?= $completed ? 'text-tertiary' : 'text-primary' ?>"><?= htmlspecialchars($ex['category'] ?? 'General') ?> &bull; <?= $ex['sets'] ?> Sets &bull; <?= $ex['reps'] ?> Reps<?= $completed ? ' &bull; COMPLETED' : '' ?></p>
                        <h4 class="font-headline-md text-headline-md leading-tight truncate <?= $completed ? 'line-through text-secondary' : '' ?>"><?= htmlspecialchars($ex['name']) ?></h4>
                    </div>
                    <?php if ($completed): ?>
                    <span class="material-symbols-outlined text-outline">chevron_right</span>
                    <?php else: ?>
                    <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container">
                        <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                    </div>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ── Rings ──────────────────────────────────────────
            ['nut-ring', 'water-ring'].forEach(function (id) {
                var circle = document.getElementById(id);
                if (!circle) return;
                var radius = circle.r.baseVal.value;
                var circumference = radius * 2 * Math.PI;
                circle.style.strokeDasharray = circumference + ' ' + circumference;
            });

            var nutCircle = document.getElementById('nut-ring');
            if (nutCircle) {
                var radius = nutCircle.r.baseVal.value;
                var circumference = radius * 2 * Math.PI;
                var offset = circumference - (<?= $caloriesPercent ?> / 100 * circumference);
                setTimeout(function () { nutCircle.style.strokeDashoffset = offset; }, 300);
            }

            var waterCircle = document.getElementById('water-ring');
            if (waterCircle) {
                var radius = waterCircle.r.baseVal.value;
                var circumference = radius * 2 * Math.PI;
                var offset = circumference - (<?= $waterPercent ?> / 100 * circumference);
                setTimeout(function () { waterCircle.style.strokeDashoffset = offset; }, 300);
            }

            // ── Chart ──────────────────────────────────────────
            var ctx = document.getElementById('progressChart');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($chartDays) ?>,
                    datasets: [
                        {
                            label: 'Calories',
                            data: <?= json_encode($chartNutrition) ?>,
                            borderColor: '#b71422',
                            backgroundColor: 'rgba(183,20,34,0.1)',
                            tension: 0.3,
                            pointRadius: 3,
                        },
                        {
                            label: 'Water (L)',
                            data: <?= json_encode($chartWater) ?>,
                            borderColor: '#006764',
                            backgroundColor: 'rgba(0,103,100,0.1)',
                            tension: 0.3,
                            pointRadius: 3,
                        },
                        {
                            label: 'Workout (min)',
                            data: <?= json_encode($chartWorkout) ?>,
                            borderColor: '#b7841a',
                            backgroundColor: 'rgba(183,132,26,0.1)',
                            tension: 0.3,
                            pointRadius: 3,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } },
                    },
                },
            });
        });
    </script>

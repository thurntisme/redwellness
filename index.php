<?php
// Dashboard data
$userName = 'Alex';
$profileImage = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBZvge-KUyLo9_aiV7NOJSIG6L3_LlkBWFyYJl9FPdC8W2lRig0FbChKCoHsaI-0FI8nT6ujOJ-ownREFgkXq2DP3ccNluU6pJol1b6HdhJcp2GlBNhqG5Gyk7vHU33qN_PJE1Ch8x85fwtY_zcFpMHiBRLhv0_CLpp1HTzuRfoyAeeTqKErAP4tKLT94hqzSlsQrow9R5dalP6w1troDJBTkjXQc7OqJy4lyaoGhPLxngFPa9vGm4Q';

// Date/time
$date = date('l, F j');
$hour = (int)date('G');
if ($hour < 12) {
    $greeting = 'Good morning';
} elseif ($hour < 18) {
    $greeting = 'Good afternoon';
} else {
    $greeting = 'Good evening';
}

// Nutrition
$caloriesLeft = 1200;
$caloriesGoal = 2400;
$caloriesPercent = round(($caloriesGoal - $caloriesLeft) / $caloriesGoal * 100);

// Water
$waterCurrent = 1.5;
$waterGoal = 2.5;
$waterPercent = round($waterCurrent / $waterGoal * 100);

// Workouts
$workouts = [
    [
        'name' => 'Morning Mobility Flow',
        'time' => '08:30 AM',
        'duration' => '20 MIN',
        'level' => 'Beginner',
        'status' => 'completed',
        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA_47CEbP-toT2bNRr1rzlW8qqBomx5xJQiIy-MvHxBfclhFRrJfS6tpmqnnwobtw8dsRvA2h_wVpsgDU2T-sYZ1_BYNsE6QtcmO5--fD60D1ya493EaAD54T2F4nZI5FspV-mKgPdcjoqt8z1b5bAdlUcEgVYc__VQ4u5KB5lTzmtPA08jXYa67JnGxv1f-t2YUIz7qnd_ICfWQ_-sYdrVWvJr6m-p9ueXmzfsQEdVgTSylkc4Vd19',
    ],
    [
        'name' => 'Strength Training',
        'time' => '05:00 PM',
        'duration' => '45 MIN',
        'level' => 'Intermediate',
        'status' => 'pending',
        'image' => $profileImage,
    ],
];

// Chart data
$chartDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
$chartNutrition = [2100, 2300, 2500, 2000, 1800, 2100, 2200];
$chartWater = [2.2, 2.5, 3.0, 3.5, 3.2, 3.0, 3.1];
$chartWorkout = [45, 0, 60, 30, 75, 20, 50];

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
                            <circle class="text-tertiary progress-ring-circle" cx="40" cy="40" fill="transparent" r="32" stroke="currentColor" stroke-dasharray="201" stroke-dashoffset="80.4" stroke-linecap="round" stroke-width="8"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <p class="font-label-caps text-label-caps"><?= $caloriesPercent ?>%</p>
                        </div>
                    </div>
                    <p class="font-headline-md text-headline-md"><?= number_format($caloriesLeft) ?></p>
                    <p class="font-body-sm text-on-surface-variant">kcal left</p>
                </div>
                <button class="mt-sm w-full py-1 bg-primary-container text-on-primary-container font-label-caps text-[10px] rounded-full shadow-sm active:scale-95 transition-all flex items-center justify-center gap-1"><span class="material-symbols-outlined text-[14px]">add</span>LOG</button>
            </div>

            <!-- Water -->
            <div class="bg-surface-container-lowest border border-surface-variant p-sm rounded-xl shadow-sm">
                <h3 class="font-label-caps text-label-caps text-secondary">WATER</h3>
                <div class="mt-sm flex flex-col items-center">
                    <div class="relative w-20 h-20 mb-sm">
                        <svg class="w-full h-full">
                            <circle class="text-primary-container/20" cx="40" cy="40" fill="transparent" r="32" stroke="currentColor" stroke-width="8"></circle>
                            <circle class="text-primary-container progress-ring-circle" cx="40" cy="40" fill="transparent" r="32" stroke="currentColor" stroke-dasharray="201" stroke-dashoffset="120.6" stroke-linecap="round" stroke-width="8"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">water_drop</span>
                        </div>
                    </div>
                    <p class="font-headline-md text-headline-md"><?= $waterCurrent ?>L</p>
                    <p class="font-body-sm text-on-surface-variant">Goal: <?= $waterGoal ?>L</p>
                </div>
                <button class="mt-sm w-full py-1 bg-primary-container text-on-primary-container font-label-caps text-[10px] rounded-full shadow-sm active:scale-95 transition-all flex items-center justify-center gap-1"><span class="material-symbols-outlined text-[14px]">add</span>LOG</button>
            </div>
        </section>

        <!-- Next Up Routine -->
        <section class="mb-lg">
            <div class="bg-primary-container text-on-primary-container p-sm rounded-xl mb-sm shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">event_note</span>
                    <h2 class="font-label-caps text-label-caps uppercase tracking-wider">your workout today</h2>
                </div>
                <span class="material-symbols-outlined opacity-80">info</span>
            </div>
            <div class="flex flex-col gap-sm">
                <?php foreach ($workouts as $workout): ?>
                <div class="bg-surface-container-lowest border border-surface-variant rounded-xl p-sm flex items-center gap-sm transition-transform active:scale-[0.98] cursor-pointer <?= $workout['status'] === 'completed' ? 'opacity-80' : '' ?>">
                    <div class="relative w-16 h-16 rounded-lg bg-surface-container flex items-center justify-center shrink-0 overflow-hidden">
                        <img class="w-full h-full object-cover" src="<?= htmlspecialchars($workout['image']) ?>" alt="<?= htmlspecialchars($workout['name']) ?>">
                        <?php if ($workout['status'] === 'completed'): ?>
                        <div class="absolute inset-0 bg-tertiary/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-tertiary bg-tertiary rounded-full p-0.5 text-[16px]">check</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <p class="font-label-caps text-label-caps <?= $workout['status'] === 'completed' ? 'text-tertiary' : 'text-primary' ?>"><?= htmlspecialchars($workout['time']) ?> &bull; <?= htmlspecialchars($workout['duration']) ?><?= $workout['status'] === 'completed' ? ' &bull; COMPLETED' : '' ?></p>
                        <h4 class="font-headline-md text-headline-md leading-tight <?= $workout['status'] === 'completed' ? 'line-through text-secondary' : '' ?>"><?= htmlspecialchars($workout['name']) ?></h4>
                        <p class="font-body-sm text-on-surface-variant">Level: <?= htmlspecialchars($workout['level']) ?></p>
                    </div>
                    <?php if ($workout['status'] === 'completed'): ?>
                    <span class="material-symbols-outlined text-outline">chevron_right</span>
                    <?php else: ?>
                    <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container">
                        <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="grid grid-cols-2 gap-sm">
            <a href="water.php" class="flex items-center justify-center gap-base py-sm bg-primary-container text-on-primary-container font-label-caps text-label-caps rounded-full shadow-md active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[20px]">water_drop</span>
                LOG WATER
            </a>
            <a href="nutrition.php" class="flex items-center justify-center gap-base py-sm border-2 border-primary text-primary font-label-caps text-label-caps rounded-full active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[20px]">restaurant_menu</span>
                LOG MEAL
            </a>
        </section>

<?php require __DIR__ . '/partials/footer.php'; ?>

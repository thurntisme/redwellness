<?php
$exerciseId = (int) ($_GET['id'] ?? 0);

require_once __DIR__ . '/inc/url.php';
require_once __DIR__ . '/inc/db.php';

$exercise = null;
if ($exerciseId) {
    $stmt = $pdo->prepare("SELECT id, name, category FROM exercises WHERE id = ?");
    $stmt->execute([$exerciseId]);
    $exercise = $stmt->fetch();
}

if (!$exercise) {
    redirect('workout');
    exit;
}

$exerciseName = $exercise['name'];
$exerciseCategory = $exercise['category'] ?? 'General';

$userId = $_SESSION['user_id'] ?? 0;
$todayLog = null;
$todaySets = 0;
$todayReps = 0;
if ($userId) {
    $logStmt = $pdo->prepare("
        SELECT sets_completed, reps_completed, logged_at
        FROM workout_logs
        WHERE user_id = ? AND exercise_id = ? AND date(logged_at) = date('now')
        LIMIT 1
    ");
    $logStmt->execute([$userId, $exerciseId]);
    $todayLog = $logStmt->fetch();
    if ($todayLog) {
        $todaySets = (int) $todayLog['sets_completed'];
        $todayReps = (int) $todayLog['reps_completed'];
    }
}

$totalSets = max(4, $todaySets ?: 4);
$completedSets = $todaySets;

require __DIR__ . '/partials/header.php';
?>
<!-- Override top app bar for exercise detail -->
<header class="fixed top-0 left-1/2 -translate-x-1/2 w-full z-50 bg-surface/80 backdrop-blur-md shadow-sm h-14 flex justify-between items-center px-container-margin max-w-lg mx-auto">
    <a href="<?= url('workout') ?>" class="active:scale-95 transition-transform p-1">
        <span class="material-symbols-outlined text-primary">arrow_back</span>
    </a>
    <h1 class="font-headline-lg-mobile text-headline-lg-mobile font-display-metrics text-primary"><?= htmlspecialchars($exerciseName) ?></h1>
    <button class="active:scale-95 transition-transform p-1">
        <span class="material-symbols-outlined text-primary">info</span>
    </button>
</header>

<style>
    .pulse-animation {
        animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse-ring {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: .7; transform: scale(1.05); }
    }
    .set-card { transition: all 0.3s ease; }
    .set-card.completed { opacity: 0.6; background-color: #f1f4f3; border-color: transparent; }
    .set-card.completed .complete-btn { background-color: #006764; pointer-events: none; }
</style>

        <!-- Form Guidance Hero -->
        <section class="mt-md">
            <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-sm border border-outline-variant bg-gradient-to-br from-primary/20 via-surface-container-highest to-tertiary/10">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                <div class="absolute inset-0 flex items-center justify-center z-0">
                    <span class="material-symbols-outlined text-[80px] text-primary/20">fitness_center</span>
                </div>
                <div class="absolute bottom-4 left-4 z-20 flex items-center gap-2">
                    <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">play_circle</span>
                    <span class="text-white font-label-caps text-label-caps">FORM GUIDE: <?= strtoupper($exerciseName) ?></span>
                </div>
            </div>
        </section>

        <!-- Exercise Info -->
        <section class="mt-md">
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-md flex items-center gap-md">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">fitness_center</span>
                </div>
                <div>
                    <h2 class="font-headline-md text-headline-md"><?= htmlspecialchars($exerciseName) ?></h2>
                    <p class="font-label-caps text-label-caps text-primary"><?= htmlspecialchars($exerciseCategory) ?></p>
                </div>
            </div>
        </section>

        <!-- Sets Tracker -->
        <section class="mt-md flex flex-col gap-4">
            <?php for ($i = 1; $i <= $totalSets; $i++): ?>
            <div class="set-card bg-surface-container-lowest p-md rounded-xl border border-outline-variant flex items-center justify-between <?= $i <= $completedSets ? 'completed' : '' ?>" data-set="<?= $i ?>">
                <div class="flex flex-col">
                    <span class="font-label-caps text-label-caps text-secondary uppercase tracking-widest">Set <?= $i ?></span>
                    <div class="mt-1">
                        <select class="rep-select bg-transparent border-none p-0 font-display-metrics text-headline-md text-on-surface focus:ring-0">
                            <option value="10" <?= $todayReps === 10 ? 'selected' : '' ?>>10 Reps</option>
                            <option value="15" <?= $todayReps === 15 || (!$todayReps && $i <= $completedSets) ? 'selected' : '' ?>>15 Reps</option>
                            <option value="20" <?= $todayReps === 20 ? 'selected' : '' ?>>20 Reps</option>
                        </select>
                    </div>
                </div>
                <button onclick="completeSet(this)" class="complete-btn px-6 py-2 rounded-full bg-primary text-white font-label-caps text-label-caps active:scale-95 transition-transform"><?= $i <= $completedSets ? 'DONE' : 'COMPLETE' ?></button>
            </div>
            <?php endfor; ?>
        </section>

        <!-- Today's Progress -->
        <section class="mt-md">
            <div class="bg-tertiary/5 rounded-xl border border-tertiary/20 p-md">
                <div class="flex items-center gap-sm mb-xs">
                    <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">today</span>
                    <h3 class="font-headline-md text-headline-md text-on-surface">Today's Progress</h3>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    <?php if ($todayLog): ?>
                        Completed <?= $todaySets ?> set<?= $todaySets !== 1 ? 's' : '' ?> &bull; <?= $todayReps ?> reps total
                    <?php else: ?>
                        Not yet logged today. Complete a set above to record your progress.
                    <?php endif; ?>
                </p>
            </div>
        </section>

        <!-- Performance History -->
        <section class="mt-xl">
            <div class="flex justify-between items-end mb-sm">
                <h3 class="font-headline-md text-headline-md text-on-surface">Performance History</h3>
                <span class="font-label-caps text-label-caps text-primary cursor-pointer">VIEW ALL</span>
            </div>
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant divide-y divide-outline-variant/30 overflow-hidden">
                <?php if ($todayLog): ?>
                <div class="px-md py-sm flex justify-between items-center bg-surface-bright/50">
                    <div>
                        <p class="font-body-lg text-body-lg font-semibold text-on-surface">Today, <?= date('g:i A', strtotime($todayLog['logged_at'])) ?></p>
                        <p class="font-body-sm text-body-sm text-secondary"><?= $todaySets ?> Set<?= $todaySets !== 1 ? 's' : '' ?> &bull; <?= $todayReps ?> Reps Total</p>
                    </div>
                    <div class="text-right">
                        <p class="font-display-metrics text-headline-md text-primary">+100%</p>
                        <p class="font-label-caps text-label-caps text-secondary">VOLUME</p>
                    </div>
                </div>
                <?php else: ?>
                <div class="px-md py-sm text-center">
                    <span class="material-symbols-outlined text-secondary/40 text-[40px]">history</span>
                    <p class="font-body-sm text-body-sm text-secondary mt-xs">No history yet. Start tracking to see your progress.</p>
                </div>
                <?php endif; ?>
                <div class="px-md py-sm flex justify-between items-center">
                    <div>
                        <p class="font-body-lg text-body-lg font-semibold text-on-surface">First workout</p>
                        <p class="font-body-sm text-body-sm text-secondary">Complete your first set to begin tracking.</p>
                    </div>
                    <div class="text-right">
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pro Tip -->
        <section class="mt-md mb-xl">
            <div class="bg-primary-fixed-dim/20 p-md rounded-xl border border-primary-fixed-dim flex gap-md items-start">
                <span class="material-symbols-outlined text-primary mt-1">lightbulb</span>
                <div>
                    <h4 class="font-body-lg text-body-lg font-bold text-on-primary-fixed-variant">Pro Tip</h4>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Keep your core tight and elbows tucked at a 45-degree angle to protect your shoulders and maximize engagement.</p>
                </div>
            </div>
        </section>

    <!-- Bottom Action Bar -->
    <footer class="fixed bottom-0 left-0 w-full p-container-margin z-50 bg-gradient-to-t from-surface via-surface/90 to-transparent" style="padding-bottom: 70px;">
        <div class="max-w-lg mx-auto flex flex-col gap-sm">
            <button onclick="completeNextSet()" class="w-full bg-primary-container text-on-primary-container h-14 rounded-full font-headline-md text-headline-md flex items-center justify-center shadow-lg active:scale-95 transition-all duration-200">
                COMPLETE SET
                <span class="material-symbols-outlined ml-2">check_circle</span>
            </button>
            <p id="set-progress" class="text-center font-label-caps text-label-caps text-secondary">SET <?= $completedSets + 1 ?> OF <?= $totalSets ?></p>
        </div>
    </footer>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script id="exercise-data" type="application/json"><?= json_encode(['id' => $exerciseId, 'name' => $exerciseName, 'category' => $exerciseCategory]) ?></script>
    <script src="/assets/js/request.js"></script>
    <script src="/assets/js/pages/exercise.js"></script>
    <script>
        const totalSets = <?= $totalSets ?>;
        let completedCount = <?= $completedSets ?>;

        function completeSet(btn) {
            const card = btn.closest('.set-card');
            if (card.classList.contains('completed')) return;
            card.classList.add('completed');
            btn.textContent = 'DONE';
            completedCount++;
            updateProgress();
            logSet();
        }

        async function logSet() {
            const res = await fetch('/ajax/workout', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'log',
                    exercise_id: <?= $exerciseId ?>,
                    sets_completed: completedCount,
                    reps_completed: 15,
                    duration_minutes: 0,
                })
            });
            const result = await res.json();
            if (result.success) {
                storeCompleted(<?= $exerciseId ?>);
            }
        }

        function storeCompleted(exerciseId) {
            const today = new Date().toISOString().split('T')[0];
            const key = 'redwellness_completed_today';
            let stored = {};
            try { stored = JSON.parse(localStorage.getItem(key) || '{}'); } catch (_) {}
            if (stored.date !== today) stored = { date: today, ids: [] };
            if (!stored.ids.includes(exerciseId)) stored.ids.push(exerciseId);
            localStorage.setItem(key, JSON.stringify(stored));
        }

        // Store already-completed state on page load
        if (<?= $completedSets ?> > 0) {
            storeCompleted(<?= $exerciseId ?>);
        }

        function completeNextSet() {
            const sets = document.querySelectorAll('.set-card');
            for (const set of sets) {
                if (!set.classList.contains('completed')) {
                    const btn = set.querySelector('.complete-btn');
                    completeSet(btn);
                    set.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    break;
                }
            }
        }

        function updateProgress() {
            const progressEl = document.getElementById('set-progress');
            if (completedCount >= totalSets) {
                progressEl.textContent = 'ALL SETS COMPLETE!';
                progressEl.classList.add('text-tertiary');
            } else {
                progressEl.textContent = `SET ${completedCount + 1} OF ${totalSets}`;
            }
        }
    </script>

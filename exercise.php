<?php
$exerciseName = 'Push-ups';
$formGuideImage = 'https://lh3.googleusercontent.com/aida-public/AB6AXuB01hmafdA6eTP-8Nu_jxki-dT-DS73aS6q8goZ5IT0KtUYG3PAw0_1p5pjkaVY-RGvmw1fvBCV9sRS_dQWdtzGBHQrRby93zdrkwBk-QDaVADXxfNe1EwFKEXaPRr2MbBVDgCWgWgtrR-wizuPLGqpJleQNVLL5NxpJLF494KzZESFBcpZj8vZFXT-MvOXF60RT5_DzHXL_W37KOw1aVlPQjgHusPLupr9XG8OSYkxWjpJdxWbbAH3';

$sets = [
    ['reps' => [10, 15, 20], 'selected' => 15],
    ['reps' => [10, 15, 20], 'selected' => 15],
    ['reps' => [10, 15, 20], 'selected' => 15],
    ['reps' => [10, 15, 20], 'selected' => 15],
];

$totalSets = count($sets);

$history = [
    ['date' => 'Today, 08:45 AM', 'detail' => '3 Sets &bull; 60 Reps Total', 'change' => '+12%', 'label' => 'VOLUME', 'color' => 'text-primary'],
    ['date' => 'Oct 24, 2023', 'detail' => '3 Sets &bull; 55 Reps Total', 'change' => '---', 'label' => 'STABLE', 'color' => 'text-on-surface-variant'],
    ['date' => 'Oct 22, 2023', 'detail' => '2 Sets &bull; 40 Reps Total', 'change' => '', 'label' => '', 'color' => ''],
];

$completedSets = 0;

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
            <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-sm border border-outline-variant bg-surface-container-highest">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('<?= htmlspecialchars($formGuideImage) ?>');"></div>
                <div class="absolute bottom-4 left-4 z-20 flex items-center gap-2">
                    <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">play_circle</span>
                    <span class="text-white font-label-caps text-label-caps">FORM GUIDE: <?= strtoupper($exerciseName) ?></span>
                </div>
            </div>
        </section>

        <!-- Sets Tracker -->
        <section class="mt-md flex flex-col gap-4">
            <?php foreach ($sets as $index => $set): ?>
            <div class="set-card bg-surface-container-lowest p-md rounded-xl border border-outline-variant flex items-center justify-between" data-set="<?= $index + 1 ?>">
                <div class="flex flex-col">
                    <span class="font-label-caps text-label-caps text-secondary uppercase tracking-widest">Set <?= $index + 1 ?></span>
                    <div class="mt-1">
                        <select class="rep-select bg-transparent border-none p-0 font-display-metrics text-headline-md text-on-surface focus:ring-0">
                            <?php foreach ($set['reps'] as $rep): ?>
                            <option value="<?= $rep ?>" <?= $rep === $set['selected'] ? 'selected' : '' ?>><?= $rep ?> Reps</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button onclick="completeSet(this)" class="complete-btn px-6 py-2 rounded-full bg-primary text-white font-label-caps text-label-caps active:scale-95 transition-transform">COMPLETE</button>
            </div>
            <?php endforeach; ?>
        </section>

        <!-- Performance History -->
        <section class="mt-xl">
            <div class="flex justify-between items-end mb-sm">
                <h3 class="font-headline-md text-headline-md text-on-surface">Performance History</h3>
                <span class="font-label-caps text-label-caps text-primary cursor-pointer">VIEW ALL</span>
            </div>
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant divide-y divide-outline-variant/30 overflow-hidden">
                <?php foreach ($history as $i => $entry): ?>
                <div class="px-md py-sm flex justify-between items-center <?= $i === 0 ? 'bg-surface-bright/50' : '' ?>">
                    <div>
                        <p class="font-body-lg text-body-lg font-semibold text-on-surface"><?= $entry['date'] ?></p>
                        <p class="font-body-sm text-body-sm text-secondary"><?= $entry['detail'] ?></p>
                    </div>
                    <div class="text-right">
                        <?php if ($entry['change']): ?>
                        <p class="font-display-metrics text-headline-md <?= $entry['color'] ?>"><?= $entry['change'] ?></p>
                        <p class="font-label-caps text-label-caps text-secondary"><?= $entry['label'] ?></p>
                        <?php else: ?>
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Pro Tip -->
        <section class="mt-md mb-xl">
            <div class="bg-primary-fixed-dim/20 p-md rounded-xl border border-primary-fixed-dim flex gap-md items-start">
                <span class="material-symbols-outlined text-primary mt-1">lightbulb</span>
                <div>
                    <h4 class="font-body-lg text-body-lg font-bold text-on-primary-fixed-variant">Pro Tip</h4>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Keep your core tight and elbows tucked at a 45-degree angle to protect your shoulders and maximize chest engagement.</p>
                </div>
            </div>
        </section>
    </main>

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

<?php
$userName = 'Alex';
$profileImage = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBZvge-KUyLo9_aiV7NOJSIG6L3_LlkBWFyYJl9FPdC8W2lRig0FbChKCoHsaI-0FI8nT6ujOJ-ownREFgkXq2DP3ccNluU6pJol1b6HdhJcp2GlBNhqG5Gyk7vHU33qN_PJE1Ch8x85fwtY_zcFpMHiBRLhv0_CLpp1HTzuRfoyAeeTqKErAP4tKLT94hqzSlsQrow9R5dalP6w1troDJBTkjXQc7OqJy4lyaoGhPLxngFPa9vGm4Q';

$today = date('l, M j');

$exercises = [
    [
        'name' => 'Barbell Squats',
        'category' => 'STRENGTH',
        'detail' => '4 Sets \u2022 12 Reps',
        'status' => 'pending',
        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBy_8KkDHmPTEy3UjQ86jnsdhCIUZkY_xIudjzuSqrPDVCB8OyKRnieE0-6s6EWCgrg1bVey5ox9j-U4TY29ZBFYmUywvxv8eWd_ZJF0rO4w8V7B13g52ZHyhctHJWqxvSFrsmXg4k-PBSEWlibdJOk72DT159xLQjtPkrolQRH7zfUWtcDi1fWQ2yZ7fqoJt6S__y5ozHY5ZT18F7YXKI2w16AB0_jMOVyTL4bsnjz3FG9mhVH3f7T',
    ],
    [
        'name' => 'Glute Stretch',
        'category' => 'STRETCH',
        'detail' => '2 Sets \u2022 60 Sec',
        'status' => 'completed',
        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC84LtMQ3u8YOLsI_q9OjWEHneqgSMqdnCsV2pdehb6OBUZ4xejkd2Gvfc8HuhvzXc5NLGicVOWMA51lzBSOrnDZaL_zrJ3LMHmV4IWMGMjJ_2I6dc7yZOIMBy8UA0ZLNeAMdLnKifXUxLaWB9hKWO8lXBO2-CKtprwLUzruxrvOz2PfA9uWFYfpwqhUxANa_XcJTr_TB8Tm80CtXRq0xoRKlyE2FTzj6yN6yucWit03qCCWy_cTAwm',
    ],
    [
        'name' => 'HIIT Sprints',
        'category' => 'CARDIO',
        'detail' => '8 Rounds \u2022 30 Sec',
        'status' => 'pending',
        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBk4hjmP6c0T8hJC6X5qIIuV6OSh-Qtc4aMPMie3vzNTgOg7dbipuwGd3UIS5bw5eyJG4CQ72i5fomJ7V9ctXpXDKc74SoB0IYt4CYtmtjanMIo13KEz5bn0IksWohODR2auMQlXxGVRJYIZqqLgEAOQJ-HjriO60cM4o4cPa1EvTuFdiFAwXdFDDbCAGfOWDsVOAkY7en_McF0rB2BMGPbuZqAJazZyjoTtd0SEQHAylmlhFSkOvWu',
    ],
];

$morningRoutine = [
    ['name' => 'Deep Breathing', 'detail' => '5 Minutes', 'icon' => 'air'],
    ['name' => 'Hydration Priming', 'detail' => '500ml Water', 'icon' => 'water_drop'],
    ['name' => 'Joint Mobility', 'detail' => 'Full Body \u2022 10 Mins', 'icon' => 'accessibility_new'],
];

require __DIR__ . '/partials/header.php';
?>

<style>
    .fill-icon { font-variation-settings: 'FILL' 1; }
    .exercise-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .exercise-card.completed { opacity: 0.7; background-color: #f1f4f3; }
</style>

        <!-- Dashboard Header -->
        <section class="mb-lg">
            <h2 class="font-headline-lg-mobile text-headline-lg-mobile mb-xs">Workout Manager</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Manage your kinetic energy and stay disciplined.</p>
        </section>

        <!-- Workout Summary -->
        <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md mb-lg">
            <h3 class="font-label-caps text-label-caps text-primary uppercase tracking-wider mb-sm">Workout Summary</h3>
            <div class="grid grid-cols-3 gap-sm text-center">
                <div class="bg-surface-container-low rounded-lg p-sm">
                    <p class="font-display-metrics text-headline-md text-on-surface"><?= count($exercises) + count($morningRoutine) ?></p>
                    <p class="font-body-sm text-secondary">Total</p>
                </div>
                <div class="bg-tertiary/10 rounded-lg p-sm">
                    <p class="font-display-metrics text-headline-md text-tertiary"><?= count(array_filter($exercises, fn($e) => $e['status'] === 'completed')) + count($morningRoutine) ?></p>
                    <p class="font-body-sm text-secondary">Done</p>
                </div>
                <div class="bg-primary/10 rounded-lg p-sm">
                    <p class="font-display-metrics text-headline-md text-primary"><?= count(array_filter($exercises, fn($e) => $e['status'] === 'pending')) ?></p>
                    <p class="font-body-sm text-secondary">Left</p>
                </div>
            </div>
        </section>

        <!-- Morning Routine -->
        <section class="mb-lg">
            <div class="bg-primary-container/10 border border-primary-container/20 p-md rounded-xl mb-sm">
                <div class="flex items-center gap-sm mb-xs">
                    <span class="material-symbols-outlined text-primary fill-icon">wb_sunny</span>
                    <h3 class="font-headline-md text-headline-md text-on-surface">Morning Routine</h3>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Prime your metabolism and focus every morning.</p>
            </div>
            <div class="space-y-sm">
                <?php foreach ($morningRoutine as $item): ?>
                <div class="exercise-card bg-surface-container-lowest border border-outline-variant p-sm rounded-xl flex items-center gap-md group cursor-pointer hover:shadow-sm" onclick="toggleComplete(this)">
                    <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-primary"><?= $item['icon'] ?></span>
                    </div>
                    <div class="flex-grow min-w-0">
                        <h4 class="font-headline-md text-body-lg font-semibold"><?= htmlspecialchars($item['name']) ?></h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant"><?= $item['detail'] ?></p>
                    </div>
                    <div class="flex items-center">
                        <div class="check-icon hidden">
                            <span class="material-symbols-outlined text-[20px] text-tertiary fill-icon">check_circle</span>
                        </div>
                        <span class="material-symbols-outlined text-[20px] text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Today's Exercises -->
        <section class="space-y-sm">
            <div class="mb-sm">
                <h3 class="font-headline-md text-headline-md">Today's Exercises</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant"><?= htmlspecialchars($today) ?></p>
            </div>

            <?php foreach ($exercises as $exercise): ?>
            <a href="exercise.php" class="exercise-card <?= $exercise['status'] === 'completed' ? 'completed' : '' ?> bg-surface-container-lowest border border-outline-variant p-sm rounded-xl flex items-center gap-md group cursor-pointer hover:shadow-sm no-underline text-on-surface">
                <div class="w-14 h-14 rounded-lg bg-surface-container overflow-hidden flex-shrink-0 relative">
                    <img class="w-full h-full object-cover" src="<?= htmlspecialchars($exercise['image']) ?>" alt="<?= htmlspecialchars($exercise['name']) ?>">
                    <?php if ($exercise['status'] === 'completed'): ?>
                    <div class="absolute inset-0 bg-primary/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-primary fill-icon">check</span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="flex-grow min-w-0">
                    <span class="font-label-caps text-label-caps text-primary"><?= $exercise['category'] ?></span>
                    <h4 class="font-headline-md text-headline-md leading-tight truncate"><?= htmlspecialchars($exercise['name']) ?></h4>
                    <p class="font-body-sm text-body-sm text-on-surface-variant"><?= $exercise['detail'] ?></p>
                </div>
                <div class="flex items-center">
                    <div class="check-icon hidden">
                        <span class="material-symbols-outlined text-[20px] text-primary fill-icon">check_circle</span>
                    </div>
                    <span class="material-symbols-outlined text-[20px] text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
                </div>
            </a>
            <?php endforeach; ?>
        </section>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script>
        function toggleComplete(element) {
            element.classList.toggle('completed');
            const checkIcon = element.querySelector('.check-icon');
            if (element.classList.contains('completed')) {
                checkIcon.classList.remove('hidden');
            } else {
                checkIcon.classList.add('hidden');
            }
        }
    </script>

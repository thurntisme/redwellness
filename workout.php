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

        <!-- Tabbed Navigation -->
        <div class="flex bg-surface-container-low p-1 rounded-xl mb-md">
            <button class="flex-1 py-3 px-2 rounded-lg font-label-caps text-label-caps transition-all bg-primary-container text-on-primary-container" id="tab-weekly" onclick="switchTab('weekly')">
                WEEKLY SCHEDULE
            </button>
            <button class="flex-1 py-3 px-2 rounded-lg font-label-caps text-label-caps transition-all text-secondary" id="tab-morning" onclick="switchTab('morning')">
                MORNING ROUTINE
            </button>
        </div>

        <!-- Weekly Schedule View -->
        <div class="space-y-md" id="view-weekly">
            <div class="flex justify-between items-end">
                <div>
                    <h3 class="font-headline-md text-headline-md">Today's Exercises</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant"><?= htmlspecialchars($today) ?></p>
                </div>
                <div class="flex gap-2">
                    <button class="w-10 h-10 flex items-center justify-center rounded-full border border-outline-variant text-primary hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined">edit</span>
                    </button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-full border border-outline-variant text-primary hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined">settings</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <?php foreach ($exercises as $exercise): ?>
                <div class="exercise-card <?= $exercise['status'] === 'completed' ? 'completed' : '' ?> bg-surface-container-lowest border border-outline-variant p-md rounded-xl flex items-center gap-md group cursor-pointer hover:shadow-sm" onclick="toggleComplete(this)">
                    <div class="w-16 h-16 rounded-xl bg-surface-container overflow-hidden flex-shrink-0">
                        <img class="w-full h-full object-cover" src="<?= htmlspecialchars($exercise['image']) ?>" alt="<?= htmlspecialchars($exercise['name']) ?>">
                    </div>
                    <div class="flex-grow">
                        <span class="font-label-caps text-label-caps text-primary"><?= $exercise['category'] ?></span>
                        <h4 class="font-headline-md text-headline-md leading-tight"><?= htmlspecialchars($exercise['name']) ?></h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant"><?= $exercise['detail'] ?></p>
                    </div>
                    <div class="status-indicator w-8 h-8 rounded-full border-2 <?= $exercise['status'] === 'completed' ? 'bg-primary border-primary text-white' : 'border-outline-variant text-transparent' ?> flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px] fill-icon">check</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Morning Routine View -->
        <div class="hidden space-y-md" id="view-morning">
            <div class="bg-primary-container/10 border border-primary-container/20 p-md rounded-xl mb-lg">
                <div class="flex items-center gap-sm mb-xs">
                    <span class="material-symbols-outlined text-primary fill-icon">wb_sunny</span>
                    <h3 class="font-headline-md text-headline-md text-on-surface">Daily Awakening</h3>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">These exercises repeat every morning to prime your metabolism and focus.</p>
            </div>
            <div class="space-y-sm">
                <?php foreach ($morningRoutine as $item): ?>
                <div class="exercise-card bg-surface-container-lowest border border-outline-variant p-md rounded-xl flex items-center justify-between group cursor-pointer" onclick="toggleComplete(this)">
                    <div class="flex items-center gap-md">
                        <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary"><?= $item['icon'] ?></span>
                        </div>
                        <div>
                            <h4 class="font-headline-md text-body-lg font-semibold"><?= htmlspecialchars($item['name']) ?></h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant"><?= $item['detail'] ?></p>
                        </div>
                    </div>
                    <div class="status-indicator w-8 h-8 rounded-full border-2 border-outline-variant flex items-center justify-center text-transparent group-[.completed]:bg-primary group-[.completed]:border-primary group-[.completed]:text-white">
                        <span class="material-symbols-outlined text-[20px] fill-icon">check</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script>
        function switchTab(tab) {
            const weeklyBtn = document.getElementById('tab-weekly');
            const morningBtn = document.getElementById('tab-morning');
            const weeklyView = document.getElementById('view-weekly');
            const morningView = document.getElementById('view-morning');

            if (tab === 'weekly') {
                weeklyBtn.classList.add('bg-primary-container', 'text-on-primary-container');
                weeklyBtn.classList.remove('text-secondary');
                morningBtn.classList.remove('bg-primary-container', 'text-on-primary-container');
                morningBtn.classList.add('text-secondary');
                weeklyView.classList.remove('hidden');
                morningView.classList.add('hidden');
            } else {
                morningBtn.classList.add('bg-primary-container', 'text-on-primary-container');
                morningBtn.classList.remove('text-secondary');
                weeklyBtn.classList.remove('bg-primary-container', 'text-on-primary-container');
                weeklyBtn.classList.add('text-secondary');
                morningView.classList.remove('hidden');
                weeklyView.classList.add('hidden');
            }
        }

        function toggleComplete(element) {
            element.classList.toggle('completed');
            const indicator = element.querySelector('.status-indicator');
            if (element.classList.contains('completed')) {
                indicator.classList.remove('border-outline-variant', 'text-transparent');
                indicator.classList.add('bg-primary', 'border-primary', 'text-white');
            } else {
                indicator.classList.add('border-outline-variant', 'text-transparent');
                indicator.classList.remove('bg-primary', 'border-primary', 'text-white');
            }
        }
    </script>

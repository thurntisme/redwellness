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
            <div class="flex justify-between items-center mb-sm">
                <h3 class="font-headline-md text-headline-md">Today's Exercises</h3>
                <button onclick="openConfigModal()" class="w-10 h-10 flex items-center justify-center rounded-full border border-outline-variant text-primary hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">tune</span>
                </button>
            </div>

            <!-- Week Day Selector -->
            <?php
            $weekDays = [];
            $dayOfWeek = (int)date('w');
            $startOfWeek = date('Y-m-d', strtotime("-{$dayOfWeek} days"));
            for ($i = 0; $i < 7; $i++) {
                $date = date('Y-m-d', strtotime("{$startOfWeek} +{$i} days"));
                $weekDays[] = [
                    'short' => date('D', strtotime($date)),
                    'num' => date('j', strtotime($date)),
                    'month' => date('M', strtotime($date)),
                    'is_today' => $date === date('Y-m-d'),
                ];
            }
            ?>
            <div class="grid grid-cols-7 gap-1 mb-sm">
                <?php foreach ($weekDays as $day): ?>
                <button onclick="selectDay(this)" class="day-pill flex flex-col items-center justify-center py-2 rounded-xl border transition-all <?= $day['is_today'] ? 'bg-primary/10 text-primary border-primary/30' : 'bg-surface-container-lowest text-secondary border-outline-variant hover:border-primary/50' ?>">
                    <span class="font-label-caps text-[9px] uppercase <?= $day['is_today'] ? 'text-primary/70' : 'text-secondary' ?>"><?= $day['short'] ?></span>
                    <span class="font-display-metrics text-[18px] leading-tight <?= $day['is_today'] ? 'text-primary' : 'text-on-surface' ?>"><?= $day['num'] ?></span>
                    <span class="font-label-caps text-[8px] uppercase <?= $day['is_today'] ? 'text-primary/60' : 'text-secondary/60' ?>"><?= $day['month'] ?></span>
                </button>
                <?php endforeach; ?>
            </div>

            <p class="font-body-sm text-body-sm text-on-surface-variant mb-sm"><?= htmlspecialchars($today) ?></p>

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

    <!-- Config Modal -->
    <div class="fixed inset-0 z-[100] hidden items-center justify-center p-container-margin" id="config-modal">
        <div class="absolute inset-0 bg-on-background/60 backdrop-blur-md" onclick="closeConfigModal()"></div>
        <div class="relative w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden max-h-[80vh] flex flex-col">
            <div class="p-md border-b border-surface-variant flex justify-between items-center">
                <h2 class="font-headline-md text-on-surface">Configure Exercises</h2>
                <button onclick="closeConfigModal()" class="text-secondary hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-md space-y-md overflow-y-auto flex-1">
                <p class="font-body-sm text-secondary">Add or remove exercises for each day.</p>
                <?php foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day): ?>
                <div class="bg-surface-container-low rounded-lg p-sm" id="day-<?= $day ?>">
                    <p class="font-label-caps text-label-caps text-primary uppercase mb-xs"><?= $day ?></p>
                    <div class="exercise-tags flex flex-wrap gap-xs mb-xs" id="tags-<?= $day ?>">
                        <?php
                        $defaultExercises = ['Barbell Squats', 'Glute Stretch', 'HIIT Sprints'];
                        $selectedForDay = in_array($day, ['Mon', 'Wed', 'Fri']) ? $defaultExercises : ($day === 'Tue' ? ['Glute Stretch'] : []);
                        foreach ($selectedForDay as $exName):
                        ?>
                        <span class="exercise-tag flex items-center gap-1 bg-primary/10 border border-primary/30 text-primary rounded-full px-3 py-1 text-sm">
                            <?= htmlspecialchars($exName) ?>
                            <button onclick="removeExercise(this, '<?= $day ?>')" class="w-4 h-4 rounded-full bg-primary/20 flex items-center justify-center hover:bg-primary/40 transition-colors">
                                <span class="material-symbols-outlined text-[12px] text-primary">close</span>
                            </button>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <div class="relative">
                        <div class="flex gap-xs">
                            <input type="text" id="input-<?= $day ?>" placeholder="Add exercise..." class="flex-1 h-9 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 font-body-sm focus:ring-2 focus:ring-primary focus:outline-none" oninput="filterSuggestions(this, '<?= $day ?>')" onkeydown="if(event.key==='Enter'){ event.preventDefault(); addExercise('<?= $day ?>'); }" onfocus="filterSuggestions(this, '<?= $day ?>')" onblur="setTimeout(() => hideSuggestions('<?= $day ?>'), 150)">
                            <button onclick="addExercise('<?= $day ?>')" class="h-9 px-3 rounded-lg bg-primary text-white font-label-caps text-[10px] active:scale-95 transition-transform">ADD</button>
                        </div>
                        <div id="suggestions-<?= $day ?>" class="hidden absolute left-0 right-12 mt-1 bg-surface-container-lowest border border-outline-variant rounded-lg shadow-lg z-10 max-h-40 overflow-y-auto"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="p-md bg-surface-container-low border-t border-surface-variant">
                <button onclick="closeConfigModal()" class="w-full py-2 rounded-full bg-primary text-white font-bold hover:opacity-90 transition-all active:scale-95">
                    Save Schedule
                </button>
            </div>
        </div>
    </div>

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

        function selectDay(btn) {
            document.querySelectorAll('.day-pill').forEach(pill => {
                pill.classList.remove('bg-primary', 'text-white', 'border-primary');
                pill.classList.add('bg-surface-container-lowest', 'text-secondary', 'border-outline-variant');
                pill.querySelectorAll('span').forEach(span => {
                    span.classList.remove('text-white/80', 'text-white', 'text-white/60');
                    if (span.classList.contains('font-display-metrics')) {
                        span.classList.add('text-on-surface');
                    } else if (span.textContent.length <= 3) {
                        span.classList.add('text-secondary');
                    } else {
                        span.classList.add('text-secondary/60');
                    }
                });
            });
            btn.classList.remove('bg-surface-container-lowest', 'border-outline-variant');
            btn.classList.add('bg-primary', 'text-white', 'border-primary');
            btn.querySelectorAll('span').forEach(span => {
                span.classList.remove('text-secondary', 'text-on-surface', 'text-secondary/60');
                if (span.classList.contains('font-display-metrics')) {
                    span.classList.add('text-white');
                } else if (span.textContent.length <= 3) {
                    span.classList.add('text-white/80');
                } else {
                    span.classList.add('text-white/60');
                }
            });
        }

        function openConfigModal() {
            const modal = document.getElementById('config-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeConfigModal() {
            const modal = document.getElementById('config-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function addExercise(day) {
            const input = document.getElementById(`input-${day}`);
            const name = input.value.trim();
            if (!name) return;
            const tags = document.getElementById(`tags-${day}`);
            const tag = document.createElement('span');
            tag.className = 'exercise-tag flex items-center gap-1 bg-primary/10 border border-primary/30 text-primary rounded-full px-3 py-1 text-sm';
            tag.innerHTML = `${name} <button onclick="removeExercise(this, '${day}')" class="w-4 h-4 rounded-full bg-primary/20 flex items-center justify-center hover:bg-primary/40 transition-colors"><span class="material-symbols-outlined text-[12px] text-primary">close</span></button>`;
            tags.appendChild(tag);
            input.value = '';
        }

        function removeExercise(btn, day) {
            btn.closest('.exercise-tag').remove();
        }

        const allExercises = <?= json_encode(array_map(fn($e) => $e['name'], $exercises)) ?>;

        function filterSuggestions(input, day) {
            const query = input.value.trim().toLowerCase();
            const container = document.getElementById(`suggestions-${day}`);
            const existing = Array.from(document.querySelectorAll(`#tags-${day} .exercise-tag`)).map(el => el.childNodes[0].textContent.trim());
            const filtered = allExercises.filter(name => !existing.includes(name) && (query === '' || name.toLowerCase().includes(query)));

            if (filtered.length === 0) {
                container.classList.add('hidden');
                return;
            }

            container.innerHTML = filtered.map(name => `
                <button onmousedown="selectSuggestion('${day}', '${name}')" class="w-full text-left px-3 py-2 font-body-sm text-on-surface hover:bg-primary/5 transition-colors">
                    ${name}
                </button>
            `).join('');
            container.classList.remove('hidden');
        }

        function hideSuggestions(day) {
            document.getElementById(`suggestions-${day}`).classList.add('hidden');
        }

        function selectSuggestion(day, name) {
            const input = document.getElementById(`input-${day}`);
            input.value = name;
            addExercise(day);
        }
    </script>

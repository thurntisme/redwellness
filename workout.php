<?php
$today = date('l, M j');

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
                    <p class="font-display-metrics text-headline-md text-on-surface" id="summary-total">0</p>
                    <p class="font-body-sm text-secondary">Total</p>
                </div>
                <div class="bg-tertiary/10 rounded-lg p-sm">
                    <p class="font-display-metrics text-headline-md text-tertiary" id="summary-done">0</p>
                    <p class="font-body-sm text-secondary">Done</p>
                </div>
                <div class="bg-primary/10 rounded-lg p-sm">
                    <p class="font-display-metrics text-headline-md text-primary" id="summary-left">0</p>
                    <p class="font-body-sm text-secondary">Left</p>
                </div>
            </div>
        </section>

        <!-- Morning Routine -->
        <section class="mb-lg">
            <div class="bg-primary-container/10 border border-primary-container/20 p-md rounded-xl mb-sm">
                <div class="flex items-center justify-between mb-xs">
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary fill-icon">wb_sunny</span>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Morning Routine</h3>
                    </div>
                    <button onclick="openMorningConfig()" class="w-10 h-10 flex items-center justify-center rounded-full border border-primary/20 text-primary hover:bg-primary/10 transition-colors">
                        <span class="material-symbols-outlined">tune</span>
                    </button>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Prime your metabolism and focus every morning.</p>
            </div>
            <div id="morning-routine-container" class="space-y-sm">
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

            <div id="today-exercises-container" class="space-y-sm"></div>
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

    <!-- Morning Routine Config Modal -->
    <div class="fixed inset-0 z-[100] hidden items-center justify-center p-container-margin" id="morning-config-modal">
        <div class="absolute inset-0 bg-on-background/60 backdrop-blur-md" onclick="closeMorningConfig()"></div>
        <div class="relative w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden max-h-[80vh] min-h-[480px] flex flex-col">
            <div class="p-md border-b border-surface-variant flex justify-between items-center">
                <h2 class="font-headline-md text-on-surface">Morning Routine</h2>
                <button onclick="closeMorningConfig()" class="text-secondary hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-md space-y-md overflow-y-auto flex-1">
                <p class="font-body-sm text-secondary">Choose exercises for your morning routine.</p>
                <div class="bg-surface-container-low rounded-lg p-sm">
                    <div class="relative">
                        <div class="flex gap-xs">
                            <input type="text" id="morning-input" placeholder="Add exercise..." class="flex-1 h-9 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 font-body-sm focus:ring-2 focus:ring-primary focus:outline-none" oninput="filterMorningSuggestions(this)" onkeydown="if(event.key==='Enter'){ event.preventDefault(); addMorningExercise(); }" onfocus="filterMorningSuggestions(this)" onblur="setTimeout(() => hideMorningSuggestions(), 150)">
                            <button onclick="addMorningExercise()" class="h-9 px-3 rounded-lg bg-primary text-white font-label-caps text-[10px] active:scale-95 transition-transform">ADD</button>
                        </div>
                        <div id="morning-suggestions" class="hidden absolute left-0 right-12 mt-1 bg-surface-container-lowest border border-outline-variant rounded-lg shadow-lg z-20 max-h-40 overflow-y-auto"></div>
                    </div>
                    <div class="flex flex-wrap gap-xs mt-sm" id="morning-tags"></div>
                </div>
            </div>
            <div class="p-md bg-surface-container-low border-t border-surface-variant flex gap-sm">
                <button onclick="cancelMorningConfig()" class="flex-1 py-2 rounded-full border border-outline-variant text-on-surface font-bold hover:bg-surface-container-high transition-all active:scale-95">
                    Cancel
                </button>
                <button onclick="saveMorningConfig()" class="flex-1 py-2 rounded-full bg-primary text-white font-bold hover:opacity-90 transition-all active:scale-95">
                    Done
                </button>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script src="/assets/js/request.js"></script>
    <script src="/assets/js/pages/workout.js"></script>

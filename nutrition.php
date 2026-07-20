<?php
$profileImage = 'https://lh3.googleusercontent.com/aida-public/AB6AXuDs6bQR4fEDNltQWEeAhnmk0XvYLFHxW9gURzT2Kdau_vXb4Lspg-kcV5-uD5su5XgLBS3vGuJs5ulcgf4juXAcbm4qCMI0ZzmJlD37cP21MjKBbl_JlJrbjct8bBiVdw5XEu0ra32gJZQwp5xFSym3S01hqlS0VdU6jciC-OosxCeOOgkEl7V2pMGrxMGygQYNSc18dSQlhFVAUJxpnD4xQl_HnOknqMhGgPmuxfRkT9uAF5uusa8n';

// Nutrition data
$caloriesLeft = 1540;
$caloriesGoal = 2500;
$caloriesPercent = round(($caloriesGoal - $caloriesLeft) / $caloriesGoal * 100);

$macros = [
    ['name' => 'Protein', 'value' => '120g', 'percent' => 75, 'color' => 'bg-primary'],
    ['name' => 'Carbs', 'value' => '185g', 'percent' => 50, 'color' => 'bg-primary/60'],
    ['name' => 'Fats', 'value' => '45g', 'percent' => 40, 'color' => 'bg-primary/40'],
];

$meals = [
    [
        'type' => 'Breakfast',
        'name' => 'Greek Yogurt Bowl with Berries',
        'kcal' => 420,
        'status' => 'logged',
        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDZPwwKtr6ndoXISOp3xzcggDCFgqZViIsw3jG5qa7o2oke7Y9l1xI-D4fyiFkxpg7RpjA15vSoEM7pHUWaKKs3WEYCv2HZhsM7HSP5f-9tFi3wXcxH03YJYu0zUU7b0AfuXb6JkMxq50HZN3JiahQkWK4sL7DFbBAtPsJsNYkU5X_UdBKq93NYsZ4MMMxt3hGpVgYW1X41gJRS38NDQWs2tMJ0vPmHh377l5aQpr7KoAfpXbsg2g1b',
    ],
    [
        'type' => 'Lunch',
        'name' => 'Grilled Chicken Quinoa Salad',
        'kcal' => 580,
        'status' => 'logged',
        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCHZ6AN90xRnzkBMtW3Ho1A8UdmI4hGH2eHoN_WsooyErZjsqFG5ligTFLHavw7isHz4bLKtKEJtsZ2m0N-bFrCKEOriPYga3Qtv7g99em2IYSwol6ayFehP7jqCmWfO5tnf65CO0OViEFOSmDPpGL_-3V-3aZzQ0NWL3qga6vJa6Eyb2FWusYpHG4zED9A9mLHfT_pDaxG_mMYpJUU5dMa1tCfbH7D1jhrAn8XfsXfRbUPCSRhaCUi',
    ],
    [
        'type' => 'Dinner',
        'name' => 'Not logged yet',
        'kcal' => 0,
        'status' => 'pending',
        'image' => '',
    ],
    [
        'type' => 'Snacks',
        'name' => 'Almonds and Small Apple',
        'kcal' => 150,
        'status' => 'logged',
        'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDyfPVEgdZhT7F70j7UtHt58PZ9grWeXvpfiYrsWWsRzMwAIwqa6hMhd7GPtxN5bzjGEeIFfuoeKJqBG_pBeLYcpXI-3Hb81q_V8qzUs2R4zK62H9eqk059FKvLVN5wM4IRBosreyNbM-fhWSAK60NKZs8KYUoSV0juu7tFfS0GtL6sIsU_e_JE8rtus5JQLffZvT6iQayNjFfwiKYtTmdR6rT5ATCiyAES35GvFiGVbl7jDzDf0Y85',
    ],
];

$hydration = ['current' => 1.8, 'goal' => 2.5];

require __DIR__ . '/partials/header.php';
?>

<style>
    .meal-card-hover:active { transform: scale(0.98); transition: transform 0.15s ease; }
    .progress-ring-circle {
        transition: stroke-dashoffset 0.35s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>

        <!-- Daily Progress Dashboard -->
        <section class="bg-surface-container-lowest rounded-xl p-md shadow-sm border border-surface-variant flex flex-col md:flex-row items-center gap-lg">
            <div class="relative w-40 h-40 flex items-center justify-center shrink-0">
                <svg class="w-full h-full" viewBox="0 0 100 100">
                    <circle class="text-primary/10 stroke-current" cx="50" cy="50" fill="transparent" r="40" stroke-width="10"></circle>
                    <circle class="text-primary stroke-current progress-ring-circle" cx="50" cy="50" fill="transparent" r="40" stroke-linecap="round" stroke-width="10" style="stroke-dasharray: 251.2; stroke-dashoffset: 62.8;"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="font-display-metrics text-headline-lg-mobile text-on-surface"><?= number_format($caloriesLeft) ?></span>
                    <span class="font-label-caps text-secondary uppercase tracking-wider">kcal left</span>
                </div>
            </div>
            <div class="flex-1 w-full space-y-md">
                <div class="flex flex-col gap-sm">
                    <?php foreach ($macros as $macro): ?>
                    <div class="flex items-center justify-between py-1 <?= !$loop->last ? 'border-b border-surface-variant/30' : '' ?>">
                        <div class="flex items-center gap-xs">
                            <div class="w-2 h-2 rounded-full <?= $macro['color'] ?>"></div>
                            <span class="font-label-caps text-secondary uppercase tracking-wider"><?= $macro['name'] ?></span>
                        </div>
                        <div class="flex items-center gap-md">
                            <span class="font-body-sm font-bold text-on-surface"><?= $macro['value'] ?></span>
                            <div class="w-32 h-2 bg-surface-container rounded-full overflow-hidden">
                                <div class="h-full <?= $macro['color'] ?> rounded-full" style="width: <?= $macro['percent'] ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="flex items-center gap-xs p-sm bg-surface-container-low rounded-lg border-l-4 border-primary">
                    <span class="material-symbols-outlined text-primary text-[20px]">info</span>
                    <p class="font-body-sm text-on-surface-variant">You're on track! Keep protein high for muscle recovery.</p>
                </div>
            </div>
        </section>

        <!-- Meal Logging Section -->
        <section class="space-y-sm">
            <h2 class="font-headline-md text-on-surface px-base">Today's Meals</h2>
            <?php foreach ($meals as $meal): ?>
            <?php if ($meal['status'] === 'pending'): ?>
            <div onclick="openMealModal()" class="meal-card-hover bg-surface-container-lowest rounded-xl border border-dashed border-outline-variant p-sm flex items-center gap-md group cursor-pointer bg-surface/50">
                <div class="w-16 h-16 rounded-lg bg-surface-container-high flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-outline text-[32px]">restaurant</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-headline-md text-outline"><?= $meal['type'] ?></h3>
                    <p class="font-body-sm text-secondary"><?= $meal['name'] ?></p>
                </div>
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary-container text-on-primary-container shadow-sm active:scale-90 transition-transform">
                    <span class="material-symbols-outlined">add</span>
                </div>
            </div>
            <?php else: ?>
            <div onclick="openMealModal()" class="meal-card-hover bg-surface-container-lowest rounded-xl border border-surface-variant p-sm flex items-center gap-md group cursor-pointer transition-all hover:shadow-md">
                <div class="w-16 h-16 rounded-lg bg-surface-container overflow-hidden shrink-0">
                    <img class="w-full h-full object-cover" src="<?= htmlspecialchars($meal['image']) ?>" alt="<?= htmlspecialchars($meal['type']) ?>">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <h3 class="font-headline-md text-on-surface truncate"><?= $meal['type'] ?></h3>
                        <span class="font-label-caps text-primary px-2 py-1 bg-primary-fixed rounded"><?= $meal['kcal'] ?> KCAL</span>
                    </div>
                    <p class="font-body-sm text-secondary truncate"><?= htmlspecialchars($meal['name']) ?></p>
                </div>
                <span class="material-symbols-outlined text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </section>

        <!-- Hydration Tracker -->
        <section class="bg-primary/5 rounded-xl p-md border border-primary/10 flex items-center justify-between">
            <div class="flex items-center gap-sm">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">water_drop</span>
                </div>
                <div>
                    <h4 class="font-body-lg font-bold text-on-surface">Hydration</h4>
                    <p class="font-body-sm text-secondary"><?= $hydration['current'] ?>L / <?= $hydration['goal'] ?>L</p>
                </div>
            </div>
            <div class="flex gap-xs">
                <button class="w-10 h-10 rounded-full bg-white border border-primary/20 flex items-center justify-center text-primary active:scale-90 transition-transform">
                    <span class="material-symbols-outlined">add</span>
                </button>
            </div>
        </section>

    <!-- Meal Selection Modal -->
    <div class="fixed inset-0 z-[100] hidden items-center justify-center p-container-margin" id="meal-modal">
        <div class="absolute inset-0 bg-on-background/60 backdrop-blur-md" onclick="closeMealModal()"></div>
        <div class="relative w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-md border-b border-surface-variant">
                <div class="flex justify-between items-center">
                    <h2 class="font-headline-md text-on-surface">Select Food Item</h2>
                    <button onclick="closeMealModal()" class="text-secondary hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>
            <div class="p-sm space-y-sm">
                <div class="max-h-[400px] overflow-y-auto space-y-sm pr-2">
                    <button class="w-full flex items-center gap-md p-sm rounded-lg border border-surface-variant hover:bg-primary/5 transition-colors group text-left">
                        <div class="w-14 h-14 rounded-lg bg-surface-container overflow-hidden shrink-0">
                            <img src="https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover" alt="Avocado Toast">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col gap-xs">
                                <h3 class="font-bold text-on-surface truncate">Avocado Toast</h3>
                                <span class="font-label-caps text-primary bg-primary-fixed px-2 py-0.5 rounded w-fit">280 kcal</span>
                            </div>
                            <p class="font-body-sm text-secondary">P: 8g &bull; C: 24g &bull; F: 18g</p>
                        </div>
                    </button>
                    <button class="w-full flex items-center gap-md p-sm rounded-lg border border-surface-variant hover:bg-primary/5 transition-colors group text-left">
                        <div class="w-14 h-14 rounded-lg bg-surface-container overflow-hidden shrink-0">
                            <img src="https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover" alt="Grilled Salmon">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col gap-xs">
                                <h3 class="font-bold text-on-surface truncate">Grilled Salmon</h3>
                                <span class="font-label-caps text-primary bg-primary-fixed px-2 py-0.5 rounded w-fit">450 kcal</span>
                            </div>
                            <p class="font-body-sm text-secondary">P: 34g &bull; C: 0g &bull; F: 28g</p>
                        </div>
                    </button>
                    <button class="w-full flex items-center gap-md p-sm rounded-lg border border-surface-variant hover:bg-primary/5 transition-colors group text-left">
                        <div class="w-14 h-14 rounded-lg bg-surface-container overflow-hidden shrink-0">
                            <img src="https://images.unsplash.com/photo-1553530666-ba11a7da3888?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover" alt="Berry Smoothie">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col gap-xs">
                                <h3 class="font-bold text-on-surface truncate">Berry Smoothie</h3>
                                <span class="font-label-caps text-primary bg-primary-fixed px-2 py-0.5 rounded w-fit">210 kcal</span>
                            </div>
                            <p class="font-body-sm text-secondary">P: 15g &bull; C: 32g &bull; F: 2g</p>
                        </div>
                    </button>
                    <button class="w-full flex items-center gap-md p-sm rounded-lg border border-surface-variant hover:bg-primary/5 transition-colors group text-left">
                        <div class="w-14 h-14 rounded-lg bg-surface-container overflow-hidden shrink-0">
                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover" alt="Quinoa Salad">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col gap-xs">
                                <h3 class="font-bold text-on-surface truncate">Quinoa Salad</h3>
                                <span class="font-label-caps text-primary bg-primary-fixed px-2 py-0.5 rounded w-fit">320 kcal</span>
                            </div>
                            <p class="font-body-sm text-secondary">P: 12g &bull; C: 45g &bull; F: 10g</p>
                        </div>
                    </button>
                </div>
            </div>
            <div class="p-md bg-surface-container-low">
                <button onclick="closeMealModal()" class="w-full py-2 rounded-full border border-primary text-primary font-bold hover:bg-primary hover:text-white transition-all active:scale-95">
                    Cancel
                </button>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const circle = document.querySelector('.progress-ring-circle');
            if (circle) {
                const radius = circle.r.baseVal.value;
                const circumference = radius * 2 * Math.PI;
                circle.style.strokeDasharray = `${circumference} ${circumference}`;
                const offset = circumference - (<?= $caloriesPercent ?> / 100 * circumference);
                setTimeout(() => {
                    circle.style.strokeDashoffset = offset;
                }, 300);
            }
        });

        function openMealModal() {
            const modal = document.getElementById('meal-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeMealModal() {
            const modal = document.getElementById('meal-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

<?php
$userId = $_SESSION['user_id'] ?? 0;
$userName = $_SESSION['user_name'] ?? 'Guest';
$userEmail = $_SESSION['user_email'] ?? '';

$calorieGoal = $_SESSION['calorie_goal'] ?? 2500;
$waterGoalMl = $_SESSION['water_goal_ml'] ?? 2500;
$proteinGoal = 150;
$carbsGoal = 250;
$fatsGoal = 65;

if ($userId) {
    $gStmt = $pdo->prepare("SELECT * FROM user_goals WHERE user_id = ?");
    $gStmt->execute([$userId]);
    $goals = $gStmt->fetch();
    if ($goals) {
        $calorieGoal = (int) $goals['calorie_goal'];
        $proteinGoal = (int) $goals['protein_goal'];
        $carbsGoal = (int) $goals['carbs_goal'];
        $fatsGoal = (int) $goals['fats_goal'];
        $waterGoalMl = (int) $goals['water_goal_ml'];
    }
}

require __DIR__ . '/partials/header.php';
?>

        <!-- Profile Picture Section -->
        <section class="flex flex-col items-center justify-center py-md space-y-sm">
            <div class="relative group">
                <div class="w-24 h-24 rounded-full border-4 border-white shadow-lg overflow-hidden bg-surface-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-[48px] text-primary">person</span>
                </div>
            </div>
            <div class="text-center">
                <h2 class="font-headline-md text-headline-md text-on-surface"><?= htmlspecialchars($userName) ?></h2>
                <p class="font-body-sm text-body-sm text-secondary"><?= htmlspecialchars($userEmail) ?></p>
            </div>
        </section>

        <!-- Personal Information Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-sm rounded-xl space-y-sm">
            <h3 class="font-label-caps text-label-caps text-primary uppercase tracking-wider">Personal Information</h3>
            <div class="space-y-xs">
                <label class="font-body-sm text-body-sm text-on-surface-variant px-1" for="username">Name</label>
                <input class="w-full h-12 bg-surface-container-low border-none rounded-lg focus:ring-2 focus:ring-primary font-body-lg text-body-lg px-4 transition-all" id="username" type="text" value="<?= htmlspecialchars($userName) ?>">
            </div>
        </div>

        <!-- Health Goals Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-sm rounded-xl space-y-md">
            <h3 class="font-label-caps text-label-caps text-primary uppercase tracking-wider">Daily Goals</h3>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="font-body-sm text-body-sm text-on-surface-variant">Calories</label>
                    <span class="font-display-metrics text-headline-md text-primary" id="calorie-display"><?= number_format($calorieGoal) ?> <span class="text-body-sm font-normal">kcal</span></span>
                </div>
                <input class="w-full h-2 bg-surface-container-high rounded-lg appearance-none cursor-pointer accent-primary" id="calorie-slider" max="4000" min="1200" step="50" type="range" value="<?= $calorieGoal ?>">
                <div class="flex justify-between mt-1 px-1">
                    <span class="font-label-caps text-[10px] text-secondary">1,200</span>
                    <span class="font-label-caps text-[10px] text-secondary">4,000</span>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="font-body-sm text-body-sm text-on-surface-variant">Water</label>
                    <span class="font-display-metrics text-headline-md text-primary" id="water-display"><?= number_format($waterGoalMl / 1000, 1) ?> <span class="text-body-sm font-normal">L</span></span>
                </div>
                <input class="w-full h-2 bg-surface-container-high rounded-lg appearance-none cursor-pointer accent-primary" id="water-slider" max="5000" min="500" step="100" type="range" value="<?= $waterGoalMl ?>">
                <div class="flex justify-between mt-1 px-1">
                    <span class="font-label-caps text-[10px] text-secondary">0.5L</span>
                    <span class="font-label-caps text-[10px] text-secondary">5.0L</span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-sm">
                <div>
                    <label class="font-body-sm text-body-sm text-on-surface-variant block mb-1">Protein (g)</label>
                    <input type="number" id="protein-goal" value="<?= $proteinGoal ?>" class="w-full h-10 bg-surface-container-low border-none rounded-lg focus:ring-2 focus:ring-primary text-center font-body-lg">
                </div>
                <div>
                    <label class="font-body-sm text-body-sm text-on-surface-variant block mb-1">Carbs (g)</label>
                    <input type="number" id="carbs-goal" value="<?= $carbsGoal ?>" class="w-full h-10 bg-surface-container-low border-none rounded-lg focus:ring-2 focus:ring-primary text-center font-body-lg">
                </div>
                <div>
                    <label class="font-body-sm text-body-sm text-on-surface-variant block mb-1">Fats (g)</label>
                    <input type="number" id="fats-goal" value="<?= $fatsGoal ?>" class="w-full h-10 bg-surface-container-low border-none rounded-lg focus:ring-2 focus:ring-primary text-center font-body-lg">
                </div>
            </div>
        </div>

        <!-- Preferences List -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden divide-y divide-outline-variant">
            <button class="w-full flex items-center justify-between p-sm hover:bg-surface-container-low transition-colors group">
                <div class="flex items-center gap-sm">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">notifications</span>
                    </div>
                    <div class="text-left">
                        <p class="font-headline-md text-body-lg text-on-surface">Notification Preferences</p>
                        <p class="font-body-sm text-body-sm text-secondary">Smart alerts &amp; reminders</p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
            </button>
            <button class="w-full flex items-center justify-between p-sm hover:bg-surface-container-low transition-colors group">
                <div class="flex items-center gap-sm">
                    <div class="w-10 h-10 rounded-lg bg-tertiary/10 flex items-center justify-center text-tertiary">
                        <span class="material-symbols-outlined">match_case</span>
                    </div>
                    <div class="text-left">
                        <p class="font-headline-md text-body-lg text-on-surface">Connected Devices</p>
                        <p class="font-body-sm text-body-sm text-secondary">2 active devices linked</p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
            </button>
            <button class="w-full flex items-center justify-between p-sm hover:bg-surface-container-low transition-colors group">
                <div class="flex items-center gap-sm">
                    <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined">lock</span>
                    </div>
                    <div class="text-left">
                        <p class="font-headline-md text-body-lg text-on-surface">Privacy &amp; Security</p>
                        <p class="font-body-sm text-body-sm text-secondary">Data sharing settings</p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
            </button>
        </div>

        <!-- Save Button -->
        <div class="pt-sm">
            <button id="save-btn" class="w-full h-14 bg-primary text-white font-headline-md text-headline-md rounded-full shadow-lg active:scale-[0.98] transition-all hover:opacity-90 flex items-center justify-center gap-sm">
                Save Changes
            </button>
        </div>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script src="/assets/js/request.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const calorieSlider = document.getElementById('calorie-slider');
            const calorieDisplay = document.getElementById('calorie-display');
            const waterSlider = document.getElementById('water-slider');
            const waterDisplay = document.getElementById('water-display');

            calorieSlider?.addEventListener('input', (e) => {
                const val = parseInt(e.target.value).toLocaleString();
                calorieDisplay.innerHTML = val + ' <span class="text-body-sm font-normal">kcal</span>';
            });

            waterSlider?.addEventListener('input', (e) => {
                const val = (parseInt(e.target.value) / 1000).toFixed(1);
                waterDisplay.innerHTML = val + ' <span class="text-body-sm font-normal">L</span>';
            });

            document.getElementById('save-btn')?.addEventListener('click', async function () {
                const originalText = this.innerText;
                this.innerText = 'Saving...';
                this.disabled = true;

                const result = await Request.post('/ajax/nutrition', {
                    action: 'update_goals',
                    calorie_goal: parseInt(calorieSlider.value),
                    water_goal_ml: parseInt(waterSlider.value),
                    protein_goal: parseInt(document.getElementById('protein-goal').value) || 150,
                    carbs_goal: parseInt(document.getElementById('carbs-goal').value) || 250,
                    fats_goal: parseInt(document.getElementById('fats-goal').value) || 65,
                });

                if (result.success) {
                    this.innerText = 'Saved!';
                    this.classList.remove('bg-primary');
                    this.classList.add('bg-tertiary');
                    setTimeout(() => {
                        this.innerText = originalText;
                        this.classList.remove('bg-tertiary');
                        this.classList.add('bg-primary');
                        this.disabled = false;
                    }, 2000);
                } else {
                    this.innerText = 'Failed';
                    setTimeout(() => {
                        this.innerText = originalText;
                        this.disabled = false;
                    }, 2000);
                }
            });
        });
    </script>

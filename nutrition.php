<?php
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
                    <circle class="text-primary stroke-current progress-ring-circle" cx="50" cy="50" fill="transparent" r="40" stroke-linecap="round" stroke-width="10" style="stroke-dasharray: 251.2; stroke-dashoffset: 251.2;"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="font-display-metrics text-headline-lg-mobile text-on-surface" id="kcal-left">2500</span>
                    <span class="font-label-caps text-secondary uppercase tracking-wider">kcal left</span>
                </div>
            </div>
            <div class="flex-1 w-full">
                <div class="flex flex-col gap-sm" id="macros-container">
                    <div class="bg-primary/5 rounded-lg px-md py-sm flex items-center justify-between">
                        <span class="font-label-caps text-label-caps text-primary/70 uppercase">Protein</span>
                        <p class="font-display-metrics text-headline-md text-primary">0g</p>
                    </div>
                    <div class="bg-primary/5 rounded-lg px-md py-sm flex items-center justify-between">
                        <span class="font-label-caps text-label-caps text-primary/70 uppercase">Carbs</span>
                        <p class="font-display-metrics text-headline-md text-primary">0g</p>
                    </div>
                    <div class="bg-primary/5 rounded-lg px-md py-sm flex items-center justify-between">
                        <span class="font-label-caps text-label-caps text-primary/70 uppercase">KCAL</span>
                        <p class="font-display-metrics text-headline-md text-primary">0</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Meal Logging Section -->
        <section class="space-y-sm">
            <h2 class="font-headline-md text-on-surface px-base">Today's Meals</h2>
            <div id="meals-container" class="space-y-sm"></div>
        </section>

    <!-- Meal Modal -->
    <div class="fixed inset-0 z-[100] hidden items-center justify-center p-container-margin" id="meal-modal">
        <div class="absolute inset-0 bg-on-background/60 backdrop-blur-md" onclick="closeMealModal()"></div>
        <div class="relative w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden max-h-[80vh] flex flex-col">
            <div class="p-md border-b border-surface-variant">
                <div class="flex justify-between items-center">
                    <h2 class="font-headline-md text-on-surface" id="meal-modal-title">Log Meal</h2>
                    <button onclick="closeMealModal()" class="text-secondary hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>
            <div class="p-md space-y-md overflow-y-auto flex-1">
                <p class="font-body-sm text-secondary">Enter the details for this meal.</p>
                <div class="space-y-sm">
                    <div>
                        <label class="font-label-caps text-label-caps text-secondary">Quick Select</label>
                        <select id="meal-select" class="w-full h-10 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 font-body-sm focus:ring-2 focus:ring-primary focus:outline-none mt-1" onchange="selectMeal(this)">
                            <option value="">Choose a meal...</option>
                        </select>
                    </div>
                    <div class="border-t border-outline-variant/30 pt-sm">
                        <div>
                            <label class="font-label-caps text-label-caps text-secondary">Food Name</label>
                            <input type="text" id="custom-food-input" placeholder="e.g. Grilled Chicken" class="w-full h-10 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 font-body-sm focus:ring-2 focus:ring-primary focus:outline-none mt-1">
                        </div>
                    <div class="grid grid-cols-2 gap-sm">
                        <div>
                            <label class="font-label-caps text-label-caps text-secondary">Calories</label>
                            <input type="number" id="custom-calories" placeholder="e.g. 420" class="w-full h-10 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 font-body-sm focus:ring-2 focus:ring-primary focus:outline-none mt-1">
                        </div>
                        <div>
                            <label class="font-label-caps text-label-caps text-secondary">Protein (g)</label>
                            <input type="number" id="custom-protein" placeholder="e.g. 30" class="w-full h-10 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 font-body-sm focus:ring-2 focus:ring-primary focus:outline-none mt-1">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-sm">
                        <div>
                            <label class="font-label-caps text-label-caps text-secondary">Carbs (g)</label>
                            <input type="number" id="custom-carbs" placeholder="e.g. 45" class="w-full h-10 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 font-body-sm focus:ring-2 focus:ring-primary focus:outline-none mt-1">
                        </div>
                        <div>
                            <label class="font-label-caps text-label-caps text-secondary">Fats (g)</label>
                            <input type="number" id="custom-fats" placeholder="e.g. 12" class="w-full h-10 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 font-body-sm focus:ring-2 focus:ring-primary focus:outline-none mt-1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-md bg-surface-container-low border-t border-surface-variant flex gap-sm">
                <button onclick="closeMealModal()" class="flex-1 py-2 rounded-full border border-outline-variant text-on-surface font-bold hover:bg-surface-container-high transition-all active:scale-95">
                    Cancel
                </button>
                <button onclick="logCustomFood()" class="flex-1 py-2 rounded-full bg-primary text-white font-bold hover:opacity-90 transition-all active:scale-95">
                    Log Meal
                </button>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script src="/assets/js/request.js"></script>
    <script src="/assets/js/pages/nutrition.js"></script>

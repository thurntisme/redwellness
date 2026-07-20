<?php
$hydrationGoal = $_SESSION['water_goal'] ?? 2.5;

require __DIR__ . '/partials/header.php';
?>

<style>
    .progress-ring-circle {
        transition: stroke-dashoffset 0.35s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>

    <main class="pt-20 px-container-margin max-w-lg mx-auto space-y-lg">
        <!-- Hero Progress Section -->
        <section class="flex flex-col items-center justify-center mb-lg">
            <div class="relative w-64 h-64 flex items-center justify-center">
                <svg class="w-full h-full" viewBox="0 0 256 256">
                    <circle class="text-primary/10" cx="128" cy="128" fill="transparent" r="110" stroke="currentColor" stroke-width="12"></circle>
                    <circle class="text-primary progress-ring-circle" cx="128" cy="128" fill="transparent" r="110" stroke="currentColor" stroke-linecap="round" stroke-width="12" style="stroke-dasharray: 691; stroke-dashoffset: 240;"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                    <span id="current-liters" class="font-display-metrics text-display-metrics text-on-surface">1.8</span>
                    <span class="font-label-caps text-label-caps text-secondary uppercase">Liters / <?= $hydrationGoal ?>L Goal</span>
                </div>
            </div>
            <p id="hydration-msg" class="mt-md font-body-lg text-secondary text-center">You're 72% hydrated today. Keep pushing!</p>
        </section>

        <!-- Quick Add Section -->
        <section class="mb-lg">
            <h2 class="font-headline-md text-headline-md mb-sm text-on-surface">Log Water</h2>
            <div class="grid grid-cols-3 gap-gutter">
                <button onclick="logWater(250)" class="flex flex-col items-center justify-center py-sm bg-surface-container-low border border-outline-variant rounded-xl active:scale-95 transition-transform hover:bg-primary/5 group">
                    <span class="material-symbols-outlined text-primary mb-xs">water_drop</span>
                    <span class="font-label-caps text-label-caps text-on-surface">250ml</span>
                </button>
                <button onclick="logWater(500)" class="flex flex-col items-center justify-center py-sm bg-surface-container-low border border-outline-variant rounded-xl active:scale-95 transition-transform hover:bg-primary/5 group">
                    <div class="flex mb-xs">
                        <span class="material-symbols-outlined text-primary">water_drop</span>
                        <span class="material-symbols-outlined text-primary -ml-2">water_drop</span>
                    </div>
                    <span class="font-label-caps text-label-caps text-on-surface">500ml</span>
                </button>
                <button onclick="logWater(750)" class="flex flex-col items-center justify-center py-sm bg-surface-container-low border border-outline-variant rounded-xl active:scale-95 transition-transform hover:bg-primary/5 group">
                    <div class="flex mb-xs">
                        <span class="material-symbols-outlined text-primary">water_drop</span>
                        <span class="material-symbols-outlined text-primary -ml-2">water_drop</span>
                        <span class="material-symbols-outlined text-primary -ml-2">water_drop</span>
                    </div>
                    <span class="font-label-caps text-label-caps text-on-surface">750ml</span>
                </button>
            </div>
        </section>

        <!-- Custom Input Button -->
        <section class="mb-lg">
            <button onclick="openCustomVolumeModal()" class="w-full h-12 flex items-center justify-center gap-xs rounded-full border border-primary text-primary font-label-caps text-label-caps active:scale-95 transition-transform">
                <span class="material-symbols-outlined text-[18px]">add</span>
                CUSTOM VOLUME
            </button>
        </section>

        <!-- Today's Log -->
        <section class="mb-xl">
            <div class="flex justify-between items-center mb-sm">
                <h2 class="font-headline-md text-headline-md text-on-surface">Today's Log</h2>
                <button class="text-primary font-label-caps text-label-caps">VIEW ALL</button>
            </div>
            <div id="water-log-container" class="space-y-base">
            </div>
        </section>
    </main>

    <!-- Confirm Delete Modal -->
    <div class="fixed inset-0 z-[100] hidden items-center justify-center p-container-margin" id="confirm-delete-modal">
        <div class="absolute inset-0 bg-on-background/60 backdrop-blur-md" onclick="closeConfirmDelete()"></div>
        <div class="relative w-full max-w-sm bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-md text-center space-y-sm">
                <span class="material-symbols-outlined text-error text-[48px]">error</span>
                <h2 class="font-headline-md text-on-surface">Delete entry?</h2>
                <p class="font-body-sm text-secondary" id="delete-modal-desc">This will remove the water log and adjust your progress.</p>
            </div>
            <div class="p-md bg-surface-container-low flex gap-sm">
                <button onclick="closeConfirmDelete()" class="flex-1 py-2 rounded-full border border-outline-variant text-secondary font-bold hover:bg-surface-container transition-all active:scale-95">
                    Cancel
                </button>
                <button onclick="executeDelete()" class="flex-1 py-2 rounded-full bg-error text-white font-bold hover:opacity-90 transition-all active:scale-95">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Custom Volume Modal -->
    <div class="fixed inset-0 z-[100] hidden items-center justify-center p-container-margin" id="custom-volume-modal">
        <div class="absolute inset-0 bg-on-background/60 backdrop-blur-md" onclick="closeCustomVolumeModal()"></div>
        <div class="relative w-full max-w-sm bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-md border-b border-surface-variant">
                <div class="flex justify-between items-center">
                    <h2 class="font-headline-md text-on-surface">Custom Volume</h2>
                    <button onclick="closeCustomVolumeModal()" class="text-secondary hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>
            <div class="p-md space-y-md">
                <div>
                    <label class="font-body-sm text-on-surface-variant block mb-xs" for="custom-ml">Amount (ml)</label>
                    <input id="custom-ml" type="number" min="1" max="5000" value="300" class="w-full h-12 bg-surface-container-low border border-outline-variant rounded-lg px-4 font-body-lg focus:ring-2 focus:ring-primary focus:outline-none">
                </div>
                <div>
                    <label class="font-body-sm text-on-surface-variant block mb-xs" for="custom-desc">Description</label>
                    <input id="custom-desc" type="text" placeholder="e.g. After workout" class="w-full h-12 bg-surface-container-low border border-outline-variant rounded-lg px-4 font-body-lg focus:ring-2 focus:ring-primary focus:outline-none">
                </div>
            </div>
            <div class="p-md bg-surface-container-low flex gap-sm">
                <button onclick="closeCustomVolumeModal()" class="flex-1 py-2 rounded-full border border-outline-variant text-secondary font-bold hover:bg-surface-container transition-all active:scale-95">
                    Cancel
                </button>
                <button onclick="confirmCustomVolume()" class="flex-1 py-2 rounded-full bg-primary text-white font-bold hover:opacity-90 transition-all active:scale-95">
                    Add
                </button>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script src="/assets/js/validate.js"></script>
    <script src="/assets/js/request.js"></script>
    <script src="/assets/js/user.js"></script>
    <script src="/assets/js/pages/water.js"></script>

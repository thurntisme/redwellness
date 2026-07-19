<?php
$profileImage = 'https://lh3.googleusercontent.com/aida-public/AB6AXuC89b6J_Xv86JuaDM4l4p-QkVnDYxE3v-4mfpwpskZxua-rIG3-Dtp98Ig2BqkkzFETMRB_d545lojAQhwFKk7Xw1JHhhuXHRPZbJlCD3WyrIfZEa7vWcudEnzaiafuOLqvA796AM_Sgh4EKBjCG-TlUQHyxopSAsrwUN3vQBvu9hfD3KSBjzSAdC2NTsClw3kHqCg90JuNvcGb-lx-GhezPcxbZyWe5QNBu-T-g_2RgBF9cPBbwfDX';

$hydrationGoal = 2.5;
$waterLogs = [
    ['amount' => 500, 'label' => 'Glass of Water', 'time' => '09:15 AM', 'icon' => 'local_drink'],
    ['amount' => 250, 'label' => 'Quick Sip', 'time' => '08:02 AM', 'icon' => 'local_drink'],
    ['amount' => 750, 'label' => 'Post-Workout', 'time' => '07:30 AM', 'icon' => 'fitness_center'],
];

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
                <?php foreach ($waterLogs as $log): ?>
                <div class="flex items-center justify-between p-sm bg-surface-container-lowest border border-outline-variant/30 rounded-xl">
                    <div class="flex items-center gap-sm">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary"><?= $log['icon'] ?></span>
                        </div>
                        <div>
                            <p class="font-body-lg font-bold text-on-surface"><?= $log['amount'] ?>ml</p>
                            <p class="font-body-sm text-secondary"><?= htmlspecialchars($log['label']) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-xs">
                        <p class="font-label-caps text-label-caps text-secondary-fixed-dim"><?= $log['time'] ?></p>
                        <button onclick="confirmDelete(this, <?= $log['amount'] ?>)" class="w-8 h-8 rounded-full flex items-center justify-center text-secondary hover:text-error hover:bg-error-container/30 transition-colors active:scale-90">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
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

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const GOAL = <?= $hydrationGoal ?>;
            const currentLiters = 1.8;
            let totalMl = currentLiters * 1000;
            const circumference = 691;

            const litersEl = document.getElementById('current-liters');
            const msgEl = document.getElementById('hydration-msg');
            const logContainer = document.getElementById('water-log-container');
            const ring = document.querySelector('.progress-ring-circle');

            function updateProgress() {
                const liters = totalMl / 1000;
                const percent = Math.min(100, Math.round((liters / GOAL) * 100));
                litersEl.textContent = liters.toFixed(1);
                msgEl.textContent = percent >= 100
                    ? 'You hit your goal! Great job staying hydrated!'
                    : `You're ${percent}% hydrated today. Keep pushing!`;
                const offset = Math.max(0, circumference - (percent / 100 * circumference));
                ring.style.strokeDashoffset = offset;
            }

            window.logWater = function (amount, label) {
                const now = new Date();
                const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                totalMl += amount;
                const displayLabel = label || 'Manual Entry';

                const newItem = document.createElement('div');
                newItem.className = 'flex items-center justify-between p-sm bg-surface-container-lowest border border-outline-variant/30 rounded-xl opacity-0 translate-y-4 transition-all duration-300';
                newItem.innerHTML = `
                    <div class="flex items-center gap-sm">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">local_drink</span>
                        </div>
                        <div>
                            <p class="font-body-lg font-bold text-on-surface">${amount}ml</p>
                            <p class="font-body-sm text-secondary">${displayLabel}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-xs">
                        <p class="font-label-caps text-label-caps text-secondary-fixed-dim">${timeStr}</p>
                        <button onclick="confirmDelete(this, ${amount})" class="w-8 h-8 rounded-full flex items-center justify-center text-secondary hover:text-error hover:bg-error-container/30 transition-colors active:scale-90">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                `;
                logContainer.prepend(newItem);
                setTimeout(() => newItem.classList.remove('opacity-0', 'translate-y-4'), 10);

                updateProgress();
            };

            window.openCustomVolumeModal = function () {
                const modal = document.getElementById('custom-volume-modal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            window.closeCustomVolumeModal = function () {
                const modal = document.getElementById('custom-volume-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            window.confirmCustomVolume = function () {
                const input = document.getElementById('custom-ml');
                const descInput = document.getElementById('custom-desc');
                const amount = parseInt(input.value);
                const label = descInput.value.trim();
                if (amount > 0) {
                    logWater(amount, label);
                    input.value = '300';
                    descInput.value = '';
                    closeCustomVolumeModal();
                }
            };

            let pendingDeleteBtn = null;
            let pendingDeleteAmount = 0;

            window.confirmDelete = function (btn, amount) {
                pendingDeleteBtn = btn.closest('.flex.items-center.justify-between');
                pendingDeleteAmount = amount;
                document.getElementById('delete-modal-desc').textContent = `This will remove ${amount}ml and adjust your progress.`;
                const modal = document.getElementById('confirm-delete-modal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            window.closeConfirmDelete = function () {
                const modal = document.getElementById('confirm-delete-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                pendingDeleteBtn = null;
                pendingDeleteAmount = 0;
            };

            window.executeDelete = function () {
                if (pendingDeleteBtn) {
                    totalMl = Math.max(0, totalMl - pendingDeleteAmount);
                    pendingDeleteBtn.style.transition = 'opacity 0.2s, transform 0.2s';
                    pendingDeleteBtn.style.opacity = '0';
                    pendingDeleteBtn.style.transform = 'translateX(20px)';
                    setTimeout(() => pendingDeleteBtn.remove(), 200);
                    updateProgress();
                }
                closeConfirmDelete();
            };
        });
    </script>

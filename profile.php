<?php
$profileImage = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBkW7epNg_R9LiBnPlTnVbCdoIYg0U4gZSj-BDzq2-SGnnGLsaWh6TyWkC5t2z9yf8_bUuSSfjlDFQiUrZhPZiUZ-m3LAkjiwULvcsbLk9W2E8y58NnXSI5sUYUJl5JpqolZIbZi3qrP7UhJcwIy7jikpNOAUcH8b7SQkFXtrvRCnn_iWCSiCUIFr9IzN_NbAJ4SvUWl_AjsNLXVe8xwBoE1B765aHXtvNAlBTu9rCDvk3pAYUfeU0B';
$avatarImage = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBLo5egX8WACIbJglrGm1qAg-b4i1GsIEvTnADZLrmNheJqiYnucQ5PF9wJzV5iZvH9wAyJbr1FJLlNVUBDl3xSI49VeYn8w9TaWrdbEGzBt2hhxy5OjqJyrGsahVpnrDUEP-DzPEciGlnyD0Kpw9Zx0LRB5NCHWGJCJ3IC2E6l_1ckhE6lUyXKanAn8vfupjOyfG_wjiSR2tSk0aJpb-vkh1kId0osnjaKQ3zzskOq83vT9Blgwj8v';

$user = [
    'name' => 'Alex Johnson',
    'email' => 'alex.j@vigorhealth.com',
    'username' => 'AlexVigor88',
    'calorieGoal' => 2400,
];

require __DIR__ . '/partials/header.php';
?>

    <main class="pt-20 px-container-margin max-w-lg mx-auto space-y-md">
        <!-- Profile Picture Section -->
        <section class="flex flex-col items-center justify-center py-md space-y-sm">
            <div class="relative group">
                <div class="w-24 h-24 rounded-full border-4 border-white shadow-lg overflow-hidden bg-surface-container">
                    <img class="w-full h-full object-cover" id="profile-preview" src="<?= htmlspecialchars($avatarImage) ?>" alt="Profile picture">
                </div>
                <button class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-full shadow-md active:scale-90 transition-transform">
                    <span class="material-symbols-outlined text-sm">edit</span>
                </button>
            </div>
            <div class="text-center">
                <h2 class="font-headline-md text-headline-md text-on-surface"><?= htmlspecialchars($user['name']) ?></h2>
                <p class="font-body-sm text-body-sm text-secondary"><?= htmlspecialchars($user['email']) ?></p>
            </div>
        </section>

        <!-- Personal Information Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-sm rounded-xl space-y-sm">
            <h3 class="font-label-caps text-label-caps text-primary uppercase tracking-wider">Personal Information</h3>
            <div class="space-y-xs">
                <label class="font-body-sm text-body-sm text-on-surface-variant px-1" for="username">Username</label>
                <input class="w-full h-12 bg-surface-container-low border-none rounded-lg focus:ring-2 focus:ring-primary font-body-lg text-body-lg px-4 transition-all" id="username" placeholder="Enter username" type="text" value="<?= htmlspecialchars($user['username']) ?>">
            </div>
        </div>

        <!-- Health Goals Card -->
        <div class="bg-surface-container-lowest border border-outline-variant p-sm rounded-xl space-y-sm">
            <div class="flex justify-between items-center">
                <h3 class="font-label-caps text-label-caps text-primary uppercase tracking-wider">Health Goals</h3>
                <span class="font-display-metrics text-headline-md text-primary" id="calorie-display"><?= number_format($user['calorieGoal']) ?> <span class="text-body-sm font-normal">kcal</span></span>
            </div>
            <div class="py-4">
                <input class="w-full h-2 bg-surface-container-high rounded-lg appearance-none cursor-pointer accent-primary" id="calorie-slider" max="4000" min="1200" step="50" type="range" value="<?= $user['calorieGoal'] ?>">
                <div class="flex justify-between mt-2 px-1">
                    <span class="font-label-caps text-[10px] text-secondary">1,200 kcal</span>
                    <span class="font-label-caps text-[10px] text-secondary">4,000 kcal</span>
                </div>
            </div>
        </div>

        <!-- Preferences List -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden divide-y divide-outline-variant">
            <!-- Notifications -->
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
            <!-- Devices -->
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
            <!-- Privacy -->
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

        <!-- Promotional/Info Section - Bento Style -->
        <div class="grid grid-cols-2 gap-sm">
            <div class="col-span-2 bg-primary-container text-on-primary-container p-sm rounded-xl flex items-center justify-between">
                <div>
                    <h4 class="font-headline-md text-body-lg font-bold">RedWellness Plus</h4>
                    <p class="font-body-sm opacity-90">Unlock advanced analytics</p>
                </div>
                <span class="material-symbols-outlined text-4xl opacity-50">workspace_premium</span>
            </div>
        </div>

        <!-- Save Button -->
        <div class="pt-sm">
            <button id="save-btn" class="w-full h-14 bg-primary text-white font-headline-md text-headline-md rounded-full shadow-lg active:scale-[0.98] transition-all hover:opacity-90 flex items-center justify-center gap-sm">
                Save Changes
            </button>
        </div>
    </main>

<?php require __DIR__ . '/partials/footer.php'; ?>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const slider = document.getElementById('calorie-slider');
            const display = document.getElementById('calorie-display');

            slider?.addEventListener('input', (e) => {
                const val = parseInt(e.target.value).toLocaleString();
                display.innerHTML = `${val} <span class="text-body-sm font-normal">kcal</span>`;
            });

            const saveBtn = document.getElementById('save-btn');
            saveBtn?.addEventListener('click', function () {
                const originalText = this.innerText;
                this.innerText = 'Updating...';
                this.classList.add('opacity-80');
                setTimeout(() => {
                    this.innerText = 'Success!';
                    this.classList.remove('bg-primary');
                    this.classList.add('bg-tertiary-container');
                    setTimeout(() => {
                        this.innerText = originalText;
                        this.classList.remove('bg-tertiary-container', 'opacity-80');
                        this.classList.add('bg-primary');
                    }, 2000);
                }, 1000);
            });
        });
    </script>

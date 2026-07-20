<?php $pageTitle = 'RedWellness - Log In'; ?>
<?php $hideMain = true; ?>
<?php require __DIR__ . '/partials/header-landing.php'; ?>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center pt-20 pb-12 px-container-margin">
        <div class="w-full max-w-md">

            <!-- Header Section -->
            <div class="mb-lg text-center">
                <h1 class="font-headline-lg-mobile text-headline-lg-mobile mb-xs">Welcome Back</h1>
                <p class="text-secondary font-body-sm">Log in to continue your wellness journey.</p>
            </div>

            <!-- Login Form -->
            <form class="space-y-gutter" id="loginForm">
                <!-- Email -->
                <div class="space-y-base">
                    <label class="font-label-caps text-label-caps text-on-surface-variant px-1" for="email">EMAIL ADDRESS</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-secondary group-focus-within:text-primary transition-colors">mail</span>
                        <input class="w-full h-12 pl-12 pr-4 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-outline/50" id="email" placeholder="name@example.com" required type="email">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-base">
                    <label class="font-label-caps text-label-caps text-on-surface-variant px-1" for="password">PASSWORD</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-secondary group-focus-within:text-primary transition-colors">lock</span>
                        <input class="w-full h-12 pl-12 pr-12 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-outline/50" id="password" placeholder="••••••••" required type="password">
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 text-secondary hover:text-on-surface transition-colors" onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined" id="passIcon">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password -->
                <div class="flex justify-end">
                    <a href="#" class="text-primary font-body-sm font-semibold hover:underline">Forgot password?</a>
                </div>

                <!-- Log In Button -->
                <button class="w-full h-12 bg-primary-container text-on-primary-container font-headline-md text-headline-md rounded-full shadow-sm hover:opacity-90 active:scale-95 transition-all flex items-center justify-center gap-2 mt-sm" type="submit">
                    Log In
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <!-- Social Auth Divider -->
            <div class="relative my-lg">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-outline-variant/30"></div>
                </div>
                <div class="relative flex justify-center text-label-caps font-label-caps">
                    <span class="bg-surface px-4 text-secondary">OR CONTINUE WITH</span>
                </div>
            </div>

            <!-- Social Buttons -->
            <div class="grid grid-cols-2 gap-gutter">
                <button class="h-12 border border-outline-variant/50 rounded-full flex items-center justify-center gap-2 hover:bg-surface-container-low transition-colors active:scale-95">
                    <img alt="Google" class="w-5 h-5 opacity-80" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBR9TbTwXd_wCKO8UUf7nMBmrXHuvsU7v_WFyv6R9Jj_u_3IhD6e72Qd37R2NFw5P5ds5tRfga9JNY_9hoYhg1bsYQrXdxw-V1_6EC6aT_EZ7j4a_0n4vuP4VeGAux07zi_diD3x_enh9Ry0nr4q1IQR3znQBtCuEguEMErHGycHsbVK9oth9cDeGOZFM3KD5ZQGWZphakFrwTcBlqxlhmhaToz3vtx_SEpLuvLb54m_8krLqutqLNe">
                    <span class="font-body-sm font-semibold">Google</span>
                </button>
                <button class="h-12 border border-outline-variant/50 rounded-full flex items-center justify-center gap-2 hover:bg-surface-container-low transition-colors active:scale-95">
                    <span class="material-symbols-outlined text-on-surface" style="font-variation-settings: 'FILL' 1;">apps</span>
                    <span class="font-body-sm font-semibold">Apple</span>
                </button>
            </div>

            <!-- Footer Link -->
            <div class="mt-xl text-center">
                <p class="text-body-sm font-body-sm text-secondary">
                    Don't have an account?
                    <a class="text-primary font-bold hover:underline transition-all" href="register.php">Sign Up</a>
                </p>
            </div>

        </div>
    </main>

    <!-- Background Decorative Elements -->
    <div class="fixed -bottom-32 -left-32 w-96 h-96 bg-primary/5 rounded-full blur-3xl -z-10 animate-pulse"></div>
    <div class="fixed -top-32 -right-32 w-64 h-64 bg-primary/5 rounded-full blur-3xl -z-10"></div>

    <script>
        function togglePassword() {
            const passInput = document.getElementById('password');
            const icon = document.getElementById('passIcon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                icon.innerText = 'visibility_off';
            } else {
                passInput.type = 'password';
                icon.innerText = 'visibility';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button[type="submit"]');
            const originalContent = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Logging in...';

            setTimeout(() => {
                btn.innerHTML = '<span class="material-symbols-outlined">check_circle</span> Welcome back!';
                btn.classList.replace('bg-primary-container', 'bg-tertiary-container');
                setTimeout(() => {
                    window.location.href = 'app.php';
                }, 1500);
            }, 1500);
        });
    </script>

<?php require __DIR__ . '/partials/footer-landing.php'; ?>

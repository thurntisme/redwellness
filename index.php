<?php $pageTitle = 'RedWellness - Your Personal Wellness Tracker'; ?>
<?php require __DIR__ . '/partials/header-landing.php'; ?>

    <!-- Hero -->
    <section class="pt-20 pb-20 px-container-margin container mx-auto text-center">
        <div class="inline-block px-4 py-1 rounded-full bg-primary/10 border border-primary/20 mb-6">
            <span class="font-label-caps text-label-caps text-primary">WELLNESS TRACKING REIMAGINED</span>
        </div>
        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-4">
            Track your <span class="text-primary">health</span>,<br>
            transform your <span class="text-tertiary">life</span>.
        </h1>
        <p class="font-body-lg text-on-surface-variant max-w-xl mx-auto mb-8">
            RedWellness is a comprehensive web app that helps you monitor nutrition, hydration, workouts, and daily wellness habits — all in one beautiful dashboard.
        </p>
        <div class="flex justify-center gap-sm">
            <a href="app.php" class="px-8 py-3 rounded-full bg-primary text-white font-headline-md shadow-lg active:scale-95 transition-all hover:opacity-90">
                Get Started
            </a>
            <a href="#features" class="px-8 py-3 rounded-full border-2 border-outline text-on-surface font-headline-md active:scale-95 transition-all hover:bg-surface-container-low">
                Learn More
            </a>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-20 px-container-margin container mx-auto">
        <div class="text-center mb-16">
            <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-4">Core Features</h2>
            <p class="font-body-lg text-on-surface-variant max-w-lg mx-auto">Everything you need to build healthier habits and stay on track with your wellness goals.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-sm">
                    <span class="material-symbols-outlined text-[28px]">restaurant_menu</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Nutrition Tracking</h3>
                <p class="font-body-sm text-on-surface-variant">Log meals, track calories, and monitor macros with an intuitive interface. Set daily goals and see your progress in real-time.</p>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-sm">
                    <span class="material-symbols-outlined text-[28px]">water_drop</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Hydration Monitor</h3>
                <p class="font-body-sm text-on-surface-variant">Track your daily water intake with quick-add buttons, custom volumes, and a visual progress ring that keeps you motivated.</p>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-sm">
                    <span class="material-symbols-outlined text-[28px]">fitness_center</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Workout Manager</h3>
                <p class="font-body-sm text-on-surface-variant">Plan weekly workouts, track sets and reps, and monitor your exercise history with detailed performance insights.</p>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-sm">
                    <span class="material-symbols-outlined text-[28px]">wb_sunny</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Morning Routine</h3>
                <p class="font-body-sm text-on-surface-variant">Build healthy morning habits with guided routines for breathing, hydration, and mobility to start every day right.</p>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-sm">
                    <span class="material-symbols-outlined text-[28px]">bar_chart</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Progress Dashboard</h3>
                <p class="font-body-sm text-on-surface-variant">Visualize your weekly trends with interactive charts covering nutrition, hydration, and workout performance.</p>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-sm">
                    <span class="material-symbols-outlined text-[28px]">calendar_today</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Weekly Planning</h3>
                <p class="font-body-sm text-on-surface-variant">Organize your exercise schedule by day of the week with a customizable planner that fits your lifestyle.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 px-container-margin">
        <div class="max-w-3xl mx-auto bg-primary-container rounded-2xl p-xl text-center text-on-primary-container">
            <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-sm">Ready to start your wellness journey?</h2>
            <p class="font-body-lg opacity-90 mb-lg max-w-md mx-auto">Join RedWellness today and take the first step towards a healthier, more disciplined life.</p>
            <a href="app.php" class="inline-block px-10 py-4 rounded-full bg-white text-primary font-headline-md shadow-lg active:scale-95 transition-all hover:opacity-90">
                Get Started Free
            </a>
        </div>
    </section>

<?php require __DIR__ . '/partials/footer-landing.php'; ?>

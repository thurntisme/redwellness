    </main>

    <!-- Bottom Navigation -->
    <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full z-50 bg-surface/95 backdrop-blur-md border-t border-outline-variant h-16 grid grid-cols-5 items-center px-2 max-w-lg mx-auto">
        <a href="<?= url('app') ?>" class="flex flex-col items-center justify-center gap-0.5 <?= isPage('app') ? 'text-primary' : 'text-secondary' ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL': <?= isPage('app') ? 1 : 0 ?>;">dashboard</span>
            <span class="text-[10px] font-semibold">Dashboard</span>
        </a>
        <a href="<?= url('workout') ?>" class="flex flex-col items-center justify-center gap-0.5 <?= isPage('workout') ? 'text-primary' : 'text-secondary' ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL': <?= isPage('workout') ? 1 : 0 ?>;">fitness_center</span>
            <span class="text-[10px] font-semibold">Workouts</span>
        </a>
        <a href="<?= url('nutrition') ?>" class="flex flex-col items-center justify-center gap-0.5 <?= isPage('nutrition') ? 'text-primary' : 'secondary' ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL': <?= isPage('nutrition') ? 1 : 0 ?>;">restaurant_menu</span>
            <span class="text-[10px] font-semibold">Nutrition</span>
        </a>
        <a href="<?= url('water') ?>" class="flex flex-col items-center justify-center gap-0.5 <?= isPage('water') ? 'text-primary' : 'text-secondary' ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL': <?= isPage('water') ? 1 : 0 ?>;">water_drop</span>
            <span class="text-[10px] font-semibold">Water</span>
        </a>
        <a href="<?= url('profile') ?>" class="flex flex-col items-center justify-center gap-0.5 <?= isPage('profile') ? 'text-primary' : 'text-secondary' ?>">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL': <?= isPage('profile') ? 1 : 0 ?>;">person</span>
            <span class="text-[10px] font-semibold">Profile</span>
        </a>
    </nav>

    <?php if (isPage('app')): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>

    <script>
        // Scroll to top on page load
        window.addEventListener('load', () => {
            window.scrollTo(0, 0);
        });
    </script>

</body>
</html>

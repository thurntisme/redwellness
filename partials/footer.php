
    </main>

    <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

    <!-- Bottom Navigation Bar -->
    <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full z-50 grid grid-cols-5 items-center px-4 py-2 pb-safe bg-surface/90 dark:bg-surface-container-low/90 backdrop-blur-md shadow-lg rounded-t-xl border-t border-outline-variant max-w-lg mx-auto">
        <a class="flex flex-col items-center justify-center <?= $currentPage === 'app.php' ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:text-primary' ?> active:scale-90 transition-transform duration-200" href="app.php">
            <span class="material-symbols-outlined" style="font-variation-settings: <?= $currentPage === 'app.php' ? "'FILL' 1" : "'FILL' 0" ?>;">dashboard</span>
            <span class="font-label-caps text-[10px]">Dashboard</span>
        </a>
        <a class="flex flex-col items-center justify-center <?= $currentPage === 'workout.php' ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:text-primary' ?> active:scale-90 transition-transform duration-200" href="workout.php">
            <span class="material-symbols-outlined" style="font-variation-settings: <?= $currentPage === 'workout.php' ? "'FILL' 1" : "'FILL' 0" ?>;">fitness_center</span>
            <span class="font-label-caps text-[10px]">Workouts</span>
        </a>
        <a class="flex flex-col items-center justify-center <?= $currentPage === 'nutrition.php' ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:text-primary' ?> active:scale-90 transition-transform duration-200" href="nutrition.php">
            <span class="material-symbols-outlined" style="font-variation-settings: <?= $currentPage === 'nutrition.php' ? "'FILL' 1" : "'FILL' 0" ?>;">restaurant_menu</span>
            <span class="font-label-caps text-[10px]">Nutrition</span>
        </a>
        <a class="flex flex-col items-center justify-center <?= $currentPage === 'water.php' ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:text-primary' ?> active:scale-90 transition-transform duration-200" href="water.php">
            <span class="material-symbols-outlined" style="font-variation-settings: <?= $currentPage === 'water.php' ? "'FILL' 1" : "'FILL' 0" ?>;">water_drop</span>
            <span class="font-label-caps text-[10px]">Water</span>
        </a>
        <a class="flex flex-col items-center justify-center <?= $currentPage === 'profile.php' ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:text-primary' ?> active:scale-90 transition-transform duration-200" href="profile.php">
            <span class="material-symbols-outlined" style="font-variation-settings: <?= $currentPage === 'profile.php' ? "'FILL' 1" : "'FILL' 0" ?>;">person</span>
            <span class="font-label-caps text-[10px]">Profile</span>
        </a>
    </nav>

<?php if ($currentPage === 'app.php'): ?>
    <script>
        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chartDays) ?>,
                datasets: [
                    {
                        label: 'Nutrition (kcal)',
                        data: <?= json_encode($chartNutrition) ?>,
                        borderColor: '#ff4d4d',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#ff4d4d',
                        yAxisID: 'y'
                    },
                    {
                        label: 'Water (L)',
                        data: <?= json_encode($chartWater) ?>,
                        borderColor: '#00827f',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 0,
                        yAxisID: 'y1'
                    },
                    {
                        label: 'Workout (min)',
                        data: <?= json_encode($chartWorkout) ?>,
                        borderColor: '#586062',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointRadius: 0,
                        yAxisID: 'y2'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 10,
                            font: { family: 'Inter', size: 10, weight: '600' }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(24, 28, 28, 0.9)',
                        titleFont: { family: 'Inter' },
                        bodyFont: { family: 'Inter' }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 10 } } },
                    y: { display: false, type: 'linear', position: 'left' },
                    y1: { display: false, type: 'linear', position: 'right' },
                    y2: { display: false, type: 'linear', position: 'right' }
                }
            }
        });
    </script>
<?php endif; ?>

    <script>
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 20) {
                header.classList.add('shadow-md');
            } else {
                header.classList.remove('shadow-md');
            }
        });
    </script>
</body>
</html>

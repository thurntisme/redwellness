<?php if (!isset($hideMain) || !$hideMain): ?>
</main>
<?php endif; ?>

    <!-- Footer -->
    <footer class="py-lg px-container-margin border-t border-outline-variant">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-sm">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary fill-icon text-[20px]">favorite</span>
                <span class="font-display-metrics text-headline-md text-primary">RedWellness</span>
            </div>
            <p class="font-body-sm text-secondary">&copy; <?= date('Y') ?> RedWellness. Built for your well-being.</p>
        </div>
    </footer>

</body>
</html>

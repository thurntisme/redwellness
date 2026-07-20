<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'RedWellness' ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Space+Grotesk:wght@600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#b71422",
                        "primary-container": "#db3237",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#fffbff",
                        "secondary": "#586062",
                        "tertiary": "#006764",
                        "tertiary-container": "#00827f",
                        "surface": "#f7faf9",
                        "surface-container-low": "#f1f4f3",
                        "surface-container-lowest": "#ffffff",
                        "surface-container": "#ebeeed",
                        "on-surface": "#181c1c",
                        "on-surface-variant": "#5b403e",
                        "outline": "#8f6f6d",
                        "outline-variant": "#e4beba"
                    },
                    "spacing": {
                        "base": "4px",
                        "sm": "16px",
                        "md": "24px",
                        "gutter": "16px",
                        "xl": "48px",
                        "xs": "8px",
                        "container-margin": "20px",
                        "lg": "32px"
                    },
                    "fontFamily": {
                        "body-sm": ["Inter"],
                        "headline-lg": ["Inter"],
                        "display-metrics": ["Space Grotesk"],
                        "headline-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "label-caps": ["Space Grotesk"]
                    },
                    "fontSize": {
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "headline-lg": ["30px", {"lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                        "display-metrics": ["48px", {"lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-md": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "30px", "fontWeight": "700"}],
                        "label-caps": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .fill-icon { font-variation-settings: 'FILL' 1; }
    </style>
</head>
<body class="bg-surface text-on-surface font-body-lg min-h-screen">

    <!-- Top Nav -->
    <header class="fixed top-0 left-0 w-full z-50 bg-surface/80 backdrop-blur-md shadow-sm h-14">
        <nav class="flex justify-between items-center gap-sm h-full container mx-auto">
            <a href="index.php" class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary fill-icon text-[28px]">favorite</span>
                <span class="font-display-metrics text-headline-lg-mobile text-primary">RedWellness</span>
            </a>
            <div class="flex items-center gap-sm">
                <a href="login.php" class="text-primary font-label-caps text-label-caps active:scale-95 transition-transform">
                    LOG IN
                </a>
                <a href="register.php" class="px-4 py-2 rounded-full bg-primary text-white font-label-caps text-label-caps active:scale-95 transition-transform">
                    GET STARTED
                </a>
            </div>
        </nav>
    </header>

<?php if (!isset($hideMain) || !$hideMain): ?>
<main class="<?= $mainClass ?? 'pt-20' ?>">
<?php endif; ?>

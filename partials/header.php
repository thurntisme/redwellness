<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RedWellness - Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Space+Grotesk:wght@600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-bright": "#f7faf9",
                        "tertiary-fixed-dim": "#2edcd7",
                        "surface-container-lowest": "#ffffff",
                        "tertiary": "#006764",
                        "surface-variant": "#e0e3e2",
                        "on-background": "#181c1c",
                        "inverse-surface": "#2d3131",
                        "surface-dim": "#d7dbda",
                        "secondary-fixed": "#dde4e6",
                        "surface": "#f7faf9",
                        "primary-fixed": "#ffdad7",
                        "primary": "#b71422",
                        "secondary-container": "#dae1e3",
                        "primary-fixed-dim": "#ffb3ae",
                        "surface-container-highest": "#e0e3e2",
                        "on-tertiary-fixed": "#00201f",
                        "secondary-fixed-dim": "#c1c8ca",
                        "on-secondary-fixed-variant": "#41484a",
                        "on-surface-variant": "#5b403e",
                        "on-tertiary-container": "#f3fffd",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "surface-container-low": "#f1f4f3",
                        "surface-container": "#ebeeed",
                        "outline": "#8f6f6d",
                        "background": "#f7faf9",
                        "on-primary-fixed": "#410004",
                        "secondary": "#586062",
                        "primary-container": "#db3237",
                        "on-primary-container": "#fffbff",
                        "on-error": "#ffffff",
                        "surface-container-high": "#e6e9e8",
                        "on-surface": "#181c1c",
                        "on-secondary": "#ffffff",
                        "tertiary-fixed": "#5af9f3",
                        "on-secondary-fixed": "#161d1f",
                        "inverse-on-surface": "#eef1f0",
                        "on-tertiary-fixed-variant": "#00504e",
                        "error": "#ba1a1a"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
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
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="font-body-lg text-on-background min-h-screen pb-32">
    <!-- Top App Bar -->
    <header class="fixed top-0 left-1/2 -translate-x-1/2 w-full z-50 bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md shadow-sm h-14 flex justify-between items-center px-container-margin max-w-lg mx-auto">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full overflow-hidden border border-outline-variant">
                <img class="w-full h-full object-cover" src="<?= htmlspecialchars($profileImage) ?>" alt="Profile">
            </div>
            <span class="font-display-metrics text-headline-lg-mobile text-primary">RedWellness</span>
        </div>
        <button class="text-primary active:scale-95 transition-transform duration-150">
            <span class="material-symbols-outlined">calendar_today</span>
        </button>
    </header>

    <main class="pt-20 px-container-margin max-w-lg mx-auto">

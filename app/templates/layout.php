<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Main CSS with Cache Busting v1.4 -->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>assets/css/style.css?v=1.4">
    <!-- Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="mac-os-theme">
    <div class="mac-window-wrapper">
        <div class="app-container">
            
            <main class="main-content">
                <?php if (!isset($isIsolated) || $isIsolated !== true): ?>
                    <?php include __DIR__ . '/header.php'; ?>
                <?php endif; ?>
                
                <div class="content-wrapper">
                    <section class="page-content">
                        <?php 
                            if (isset($viewPath) && file_exists($viewPath)) {
                                include $viewPath;
                            }
                        ?>
                    </section>
                </div>
                
                <?php if (!isset($isIsolated) || $isIsolated !== true): ?>
                    <?php include __DIR__ . '/footer.php'; ?>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Spotlight Search Overlay (Global) -->
    <div id="spotlightOverlay" class="spotlight-overlay" style="display:none;">
        <div class="spotlight-modal">
            <div class="spotlight-header">
                <span class="spotlight-icon">🔍</span>
                <input type="text" id="globalSpotlightInput" placeholder="Spotlight: Busca colaboradores, feedback o temas..." autocomplete="off">
                <span class="spotlight-esc">ESC</span>
            </div>
            <div id="spotlightResults" class="spotlight-results"></div>
        </div>
    </div>

    <script>
        window.APP_URL = "<?php echo URL_ROOT; ?>";
    </script>
    <script src="<?php echo URL_ROOT; ?>assets/js/charts.js?v=1.5"></script>
    <script src="<?php echo URL_ROOT; ?>assets/js/search.js?v=1.5"></script>
</body>
</html>

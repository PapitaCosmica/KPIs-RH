<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> v1.5.1</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Main CSS with Cache Busting v1.5.1 -->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>assets/css/style.css?v=1.5.1">
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

    <!-- Detailed Results Modal (Neomorphic) -->
    <div id="detailsModal" class="modal-overlay" style="display:none;">
        <div class="modal-content glass-card ripple">
            <div class="modal-header">
                <div class="header-info">
                    <h2 id="modalName">Nombre del Colaborador</h2>
                    <p id="modalSub">Puesto | Coordinación</p>
                </div>
                <button class="btn-close-modal" id="btnCloseModal">✕</button>
            </div>
            <div class="modal-body">
                <div class="modal-grid">
                    <div class="modal-section scores-breakdown">
                        <h3>Métricas de Desempeño</h3>
                        <div id="modalScores" class="scores-container">
                            <!-- JS Injection -->
                        </div>
                    </div>
                    <div class="modal-section feedback-section">
                        <h3>Feedback Cualitativo</h3>
                        <div id="modalFeedback" class="feedback-container">
                            <!-- JS Injection -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.15);
        backdrop-filter: blur(10px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2000;
        animation: fadeIn 0.3s ease;
    }
    .modal-content {
        width: 90%;
        max-width: 900px;
        max-height: 90vh;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 30px;
        padding: 2.5rem;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 1.5rem;
    }
    .header-info h2 { font-size: 2rem; margin-bottom: 0.5rem; color: var(--color-night); }
    .header-info p { color: var(--color-ice-blue); font-weight: 600; font-size: 1rem; }
    .btn-close-modal {
        background: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }
    .btn-close-modal:hover { transform: scale(1.1); background: #eee; }
    
    .modal-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
    }
    .modal-section h3 {
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #888;
        margin-bottom: 1.5rem;
    }
    .scores-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .score-item {
        background: white;
        padding: 1rem;
        border-radius: 15px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .score-val { font-size: 1.4rem; font-weight: 800; color: var(--color-ice-blue); }
    .score-label { font-size: 0.75rem; color: #777; margin-top: 0.3rem; }
    
    .feedback-item {
        margin-bottom: 1.5rem;
        background: rgba(255,255,255,0.4);
        padding: 1.2rem;
        border-radius: 15px;
        border-right: 4px solid var(--color-ice-blue);
    }
    .fb-label { font-size: 0.8rem; font-weight: 700; color: var(--color-night); display: block; margin-bottom: 0.5rem; }
    .fb-text { font-size: 0.95rem; color: #555; line-height: 1.5; }

    @media (max-width: 768px) {
        .modal-grid { grid-template-columns: 1fr; }
        .modal-content { padding: 1.5rem; }
    }
    </style>

    <script>
        window.APP_URL = "<?php echo URL_ROOT; ?>";
    </script>
    <script src="<?php echo URL_ROOT; ?>assets/js/charts.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="<?php echo URL_ROOT; ?>assets/js/search.js?v=<?php echo time(); ?>"></script>
    <script type="module" src="<?php echo URL_ROOT; ?>assets/js/filter.js?v=<?php echo time(); ?>"></script>
</body>
</html>

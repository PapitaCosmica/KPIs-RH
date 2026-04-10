<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Main CSS (Glassmorphism) -->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/assets/css/style.css">
    <!-- Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="glass-layout">
    <div class="app-container">
        <?php include_once TEMPLATES_PATH . '/sidebar.php'; ?>
        
        <main class="main-content">
            <?php include_once TEMPLATES_PATH . '/header.php'; ?>
            
            <section class="page-content">
                <!-- Content injected here -->
                <div class="glass-card">
                    <h1>Bienvenido al Dashboard</h1>
                    <p>Cargando datos del sistema...</p>
                </div>
            </section>
            
            <?php include_once TEMPLATES_PATH . '/footer.php'; ?>
        </main>
    </div>
</body>
</html>

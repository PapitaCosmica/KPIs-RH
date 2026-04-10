<?php
/**
 * Front Controller (Router)
 */

// Load Configurations
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';

// Advanced Router (Phase 9)
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$viewPath = '';

switch ($url) {
    case 'survey':
        $viewPath = VIEWS_PATH . '/evaluaciones/form.php';
        $isIsolated = true;
        break;
    case 'evaluaciones':
    case 'home':
        $viewPath = VIEWS_PATH . '/evaluaciones/index.php';
        break;
    case 'export/download':
        require_once CONTROLLERS_PATH . '/ExportController.php';
        $controller = new App\Controllers\ExportController();
        $controller->download();
        exit;
    default:
        $viewPath = VIEWS_PATH . '/evaluaciones/index.php';
        break;
}

// Load global layout
require_once TEMPLATES_PATH . '/layout.php';

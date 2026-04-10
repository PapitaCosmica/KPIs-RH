<?php
/**
 * Front Controller (Router)
 */

// Load Configurations
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/models/Evaluation.php';
require_once __DIR__ . '/../app/controllers/EvaluationController.php';

use App\Controllers\EvaluationController;

$controller = new EvaluationController();
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$viewPath = '';
$evaluaciones = [];
$isIsolated = false;

switch ($url) {
    case 'survey':
        $viewPath = VIEWS_PATH . '/evaluaciones/form.php';
        $isIsolated = true;
        break;
    
    case 'evaluaciones':
        $evaluaciones = $controller->index();
        $viewPath = VIEWS_PATH . '/evaluaciones/index.php';
        break;

    case 'export/download':
        require_once CONTROLLERS_PATH . '/ExportController.php';
        $exportController = new App\Controllers\ExportController();
        $exportController->download();
        exit;
        
    case 'home':
    default:
        $url = 'home';
        $viewPath = VIEWS_PATH . '/home/index.php';
        break;
}

// Load global layout
require_once TEMPLATES_PATH . '/layout.php';

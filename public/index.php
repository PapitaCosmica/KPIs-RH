<?php
/**
 * Front Controller (Router)
 */

// Load Autoloader & Configurations
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Controllers\EvaluationController;
use App\Controllers\ExportController;

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

    case 'survey/store':
        $controller->store($_POST);
        exit;

    case 'survey/create-tunnel':
        $controller->createTunnel();
        exit;

    case 'survey/tunnel':
        $controller->viewTunnel();
        exit;

    case 'survey/update-tunnel-base':
        $controller->updateTunnelBase();
        exit;

    case 'survey/thanks':
        $viewPath = VIEWS_PATH . '/evaluaciones/thanks.php';
        $isIsolated = true;
        break;
    
    case 'resultados':
    case 'evaluaciones':
        $evaluaciones = $controller->index();
        $viewPath = VIEWS_PATH . '/evaluaciones/index.php';
        $url = 'resultados';
        break;

    case 'export/download':
        $exportController = new ExportController();
        $exportController->download();
        exit;
        
    case 'apiSearch':
        $controller->apiSearch($_GET);
        exit;
        
    case 'home':
    default:
        $url = 'home';
        $viewPath = VIEWS_PATH . '/home/index.php';
        break;
}

// Load global layout
require_once TEMPLATES_PATH . '/layout.php';

<?php
/**
 * Vercel Serverless Entry Point (Optimized Router)
 */

// 1. Diagnostics (Optional, remove after debug)
if (isset($_GET['debug'])) {
    header('Content-Type: text/plain');
    echo "Current Dir: " . __DIR__ . "\n";
    echo "Root Dir: " . dirname(__DIR__) . "\n";
    echo "Files in app/Controllers: " . implode(", ", scandir(dirname(__DIR__) . '/app/Controllers')) . "\n";
    exit;
}

// 2. Load Autoloader & Configurations
// On Vercel, __DIR__ is /var/task/user/api/
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Controllers\EvaluationController;
use App\Controllers\ExportController;

// 3. Routing Logic (Mirroring public/index.php for Vercel)
$controller = new EvaluationController();
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$viewPath = '';
$evaluaciones = [];
$isIsolated = false;

// Normalize URL for consistency
$url = trim($url, '/');

switch ($url) {
    case 'survey':
        $viewPath = VIEWS_PATH . '/evaluaciones/form.php';
        $isIsolated = true;
        break;

    case 'survey/store':
        $controller->store($_POST);
        exit;

    case 'survey/thanks':
        $viewPath = VIEWS_PATH . '/evaluaciones/thanks.php';
        $isIsolated = true;
        break;
    
    case 'evaluaciones':
        $evaluaciones = $controller->index();
        $viewPath = VIEWS_PATH . '/evaluaciones/index.php';
        break;

    case 'export/download':
        $exportController = new ExportController();
        $exportController->download();
        exit;
        
    case 'apiSearch':
        $controller->apiSearch($_GET);
        exit;
        
    case 'home':
    case '':
    default:
        $url = 'home';
        $viewPath = VIEWS_PATH . '/home/index.php';
        break;
}

// 4. Load global layout
require_once TEMPLATES_PATH . '/layout.php';

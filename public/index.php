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

// --- Simple System Authentication ---
$restricted_urls = ['home', 'resultados', 'evaluaciones', 'export/download', 'apiSearch'];
$isRestricted = in_array($url, $restricted_urls) || empty($url) || $url === '/';
$adminPass = 'rh2026';

if ($url === 'login/submit' && isset($_POST['password'])) {
    if ($_POST['password'] === $adminPass) {
        setcookie('kpi_auth', 'unlocked', time() + 86400 * 30, '/'); // 30 days
        header("Location: " . URL_ROOT . "?url=home");
        exit;
    } else {
        header("Location: " . URL_ROOT . "?url=login&err=1");
        exit;
    }
}

if ($url === 'logout') {
    setcookie('kpi_auth', '', time() - 3600, '/');
    header("Location: " . URL_ROOT . "?url=login");
    exit;
}

if ($isRestricted && (!isset($_COOKIE['kpi_auth']) || $_COOKIE['kpi_auth'] !== 'unlocked')) {
    $url = 'login';
}
// ----------------------------------

switch ($url) {
    case 'login':
        $viewPath = VIEWS_PATH . '/auth/login.php';
        $isIsolated = true; // no headers
        break;
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

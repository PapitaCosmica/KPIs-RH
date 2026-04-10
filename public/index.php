<?php
/**
 * Front Controller (Router)
 */

// Load Configurations
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';

// Simple Router (Phase 1)
$url = isset($_GET['url']) ? $_GET['url'] : 'home';

// For now, we load the global layout which acts as our main view container
require_once TEMPLATES_PATH . '/layout.php';

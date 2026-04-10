<?php
/**
 * Global Configuration Variables
 */

// Define application roots
define('APP_ROOT', dirname(__DIR__));
define('URL_ROOT', 'http://localhost/KPIs-RH/public');
define('APP_NAME', 'Dashboard Onboarding RH');

// Versioning
define('APP_VERSION', '1.0.0');

// Path constants
define('MODELS_PATH', APP_ROOT . '/app/models');
define('VIEWS_PATH', APP_ROOT . '/app/views');
define('CONTROLLERS_PATH', APP_ROOT . '/app/controllers');
define('TEMPLATES_PATH', APP_ROOT . '/app/templates');

// Timezone
date_default_timezone_set('America/Mexico_City');

// Display Errors (Set false for production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

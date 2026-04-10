<?php
/**
 * Migration Script - Automates SQL Execution
 */

require_once __DIR__ . '/../config/db.php';

use Config\Database;

try {
    $db = Database::getInstance()->getConnection();
    echo "--- Iniciando Migraciones ---\n";

    $migrationsDir = __DIR__ . '/migrations';
    $files = scandir($migrationsDir);

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
            echo "Ejecutando: $file... ";
            
            $sql = file_get_contents($migrationsDir . '/' . $file);
            
            // Execute the SQL
            $db->exec($sql);
            
            echo "DONE\n";
        }
    }

    echo "--- Migraciones Completadas ---\n";

} catch (Exception $e) {
    echo "ERROR durante la migración: " . $e->getMessage() . "\n";
}

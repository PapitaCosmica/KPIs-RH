<?php
/**
 * Database Connection - Singleton Pattern
 * Senior Architect Design for KPIs-RH Onboarding Dashboard
 */

namespace Config;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $connection;

    // Database configuration
    private $host = 'localhost';
    private $db_name = 'onboarding_db';
    private $username = 'root';
    private $password = ''; // Default XAMPP empty password
    private $charset = 'utf8mb4';

    private function __construct() {
        // Dynamic detection for Vercel/Cloud to avoid connection errors
        if (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'vercel.app')) {
            $this->connection = null;
            return;
        }

        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_PERSISTENT         => true
        ];

        // Modern PDO constant handling for PHP 8.5+
        if (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
            $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES {$this->charset}";
        }

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            // Log local connection error but don't crash the entire app if on Cloud
            error_log("Connection Error: " . $e->getMessage());
            $this->connection = null; // Set to null instead of dying
        }
    }

    /**
     * Get the single instance of the class
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the PDO connection
     */
    public function getConnection() {
        return $this->connection;
    }

    // Prevent cloning and unserialization
    private function __clone() {}
    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}

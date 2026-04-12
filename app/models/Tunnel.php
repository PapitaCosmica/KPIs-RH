<?php

namespace App\Models;

use Config\Database;
use PDO;

class Tunnel {
    private $db;
    private $table = 'survey_tunnels';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Create a new temporary tunnel
     */
    public function create($maxResponses, $hours) {
        $token = bin2hex(random_bytes(16)); // Secure 32-char token
        
        // Logical Priority: If a response limit is set (<1000), ignore time limit (set far future)
        // If responses are unlimited (>=1000), strictly use the time limit
        if ($maxResponses < 1000) {
            $expiresAt = date('Y-m-d H:i:s', strtotime("+1 year"));
        } else {
            $expiresAt = date('Y-m-d H:i:s', strtotime("+$hours hours"));
        }

        $sql = "INSERT INTO {$this->table} (token, max_responses, expires_at) VALUES (:token, :max_responses, :expires_at)";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute([
            ':token' => $token,
            ':max_responses' => $maxResponses,
            ':expires_at' => $expiresAt
        ])) {
            return $token;
        }
        return false;
    }

    /**
     * Validate a tunnel token
     */
    public function validate($token) {
        $sql = "SELECT * FROM {$this->table} WHERE token = :token AND expires_at > NOW() AND current_responses < max_responses LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Increment the response count for a tunnel
     */
    public function incrementUsage($token) {
        $sql = "UPDATE {$this->table} SET current_responses = current_responses + 1 WHERE token = :token";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':token' => $token]);
    }
}

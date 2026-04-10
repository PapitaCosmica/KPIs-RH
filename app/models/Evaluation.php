<?php
/**
 * Evaluation Model - Phase 2
 * Logic for KPIs and Data Persistence
 */

namespace App\Models;

use Config\Database;
use PDO;
use Exception;

class Evaluation {
    private $db;
    
    // Properties mapping the table columns
    public $id;
    public $num_empleado;
    public $nombre;
    public $puesto;
    public $coordinacion;
    public $fecha_ingreso;
    
    // 18 Metrics
    public $metrics = [];
    public $feedback = [];
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Group metrics by dimensions and calculate averages (0-100)
     */
    public function calculateScores($data = null) {
        $source = $data ?? $this->metrics;
        
        $dimensions = [
            'Claridad' => ['m_claridad_rol', 'm_bienvenida_equipo', 'm_capacitacion', 'm_procesos', 'm_objetivos', 'm_calidad_induccion'],
            'Cultura' => ['m_cultura', 'm_relacion_jefe', 'm_entorno_fisico', 'm_integracion_social', 'm_valores'],
            'Liderazgo' => ['m_vision'],
            'Operaciones' => ['m_herramientas'],
            'Satisfacción' => ['m_acceso_sistemas', 'm_beneficios', 'm_seguridad', 'm_soporte_rh', 'm_expectativas']
        ];

        $results = [];
        $totalSum = 0;
        $totalCount = 18;

        foreach ($dimensions as $name => $fields) {
            $sum = 0;
            foreach ($fields as $field) {
                $val = isset($source[$field]) ? (int)$source[$field] : 0;
                $sum += $val;
                $totalSum += $val;
            }
            // Average in scale 0-100 (since each metric is 1-10)
            $avg = (count($fields) > 0) ? ($sum / (count($fields) * 10)) * 100 : 0;
            $results[$name] = round($avg, 2);
        }

        // IGEO: Índice Global de Efectividad del Onboarding
        $results['IGEO'] = round(($totalSum / ($totalCount * 10)) * 100, 2);

        return $results;
    }

    /**
     * Save evaluation to database with duplicate prevention
     */
    public function save($data) {
        // 1. Check if employee already has an evaluation
        if ($this->exists($data['num_empleado'])) {
            throw new Exception("El empleado con número {$data['num_empleado']} ya cuenta con una evaluación registrada.");
        }

        // 2. Prepare SQL
        $sql = "INSERT INTO onboarding_evaluations (
                    num_empleado, nombre, puesto, coordinacion, fecha_ingreso,
                    m_claridad_rol, m_bienvenida_equipo, m_herramientas, m_acceso_sistemas,
                    m_cultura, m_relacion_jefe, m_entorno_fisico, m_capacitacion,
                    m_procesos, m_objetivos, m_integracion_social, m_valores,
                    m_vision, m_beneficios, m_seguridad, m_soporte_rh,
                    m_calidad_induccion, m_expectativas,
                    f_comentarios_generales, f_sugerencias_mejora, f_obstaculos, f_lo_mejor, f_lo_peor
                ) VALUES (
                    :num_empleado, :nombre, :puesto, :coordinacion, :fecha_ingreso,
                    :m_claridad_rol, :m_bienvenida_equipo, :m_herramientas, :m_acceso_sistemas,
                    :m_cultura, :m_relacion_jefe, :m_entorno_fisico, :m_capacitacion,
                    :m_procesos, :m_objetivos, :m_integracion_social, :m_valores,
                    :m_vision, :m_beneficios, :m_seguridad, :m_soporte_rh,
                    :m_calidad_induccion, :m_expectativas,
                    :f_comentarios_generales, :f_sugerencias_mejora, :f_obstaculos, :f_lo_mejor, :f_lo_peor
                )";

        $stmt = $this->db->prepare($sql);
        
        // Execute with mapped data
        return $stmt->execute($data);
    }

    /**
     * Check if num_empleado already exists
     */
    public function exists($num_empleado) {
        $stmt = $this->db->prepare("SELECT id FROM onboarding_evaluations WHERE num_empleado = :num_empleado LIMIT 1");
        $stmt->execute(['num_empleado' => $num_empleado]);
        return $stmt->fetch() ? true : false;
    }

    /**
     * Advanced Dynamic Filter
     */
    public function filter($params) {
        $sql = "SELECT * FROM onboarding_evaluations WHERE 1=1";
        $binds = [];

        if (!empty($params['num_empleado'])) {
            $sql .= " AND num_empleado = :num_empleado";
            $binds['num_empleado'] = $params['num_empleado'];
        }

        if (!empty($params['nombre'])) {
            $sql .= " AND nombre LIKE :nombre";
            $binds['nombre'] = "%" . $params['nombre'] . "%";
        }

        if (!empty($params['coordinacion'])) {
            $sql .= " AND coordinacion = :coordinacion";
            $binds['coordinacion'] = $params['coordinacion'];
        }

        if (!empty($params['puesto'])) {
            $sql .= " AND puesto = :puesto";
            $binds['puesto'] = $params['puesto'];
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($binds);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

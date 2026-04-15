<?php
/**
 * Evaluation Model - Final Phase
 * Logic for 30 metrics/fields and Data Persistence
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
    public $fecha_realizacion;
    public $email;
    
    // 19 Metrics (Quantitative) including new arrivals
    public $metrics = [
        'm_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_preparacion_capacitacion',
        'm_integracion_equipo', 'm_experiencia_colaboracion', 'm_accesibilidad_jefe', 
        'm_retroalimentacion_jefe', 'm_conocimiento_cultura', 'm_alineacion_valores', 
        'm_organizacion_induccion', 'm_claridad_procedimientos', 'm_herramientas_trabajo', 
        'm_espacio_fisico', 'm_atencion_rh', 'm_paquete_beneficios', 'm_proceso_administrativo',
        'm_percepcion_imagen', 'm_efectividad_onboarding', 'm_contribucion_resultados',
        'f_tiempo_onboarding', 'f_satisfaccion_decision'
    ];
    
    // 5 Feedback (Qualitative)
    public $feedback = [
        'f_logros', 'f_utilidad_capacitaciones', 'f_faltantes_actividades', 
        'f_mejoras_proceso', 'f_comentarios_libres'
    ];
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Group metrics by dimensions and calculate averages (0-100)
     */
    public function calculateScores($data = null) {
        $source = $data ?? [];
        
        // Detailed Mapping based on Table Requirement:
        // GREEN: 1, 2, 5, 7  -> Claridad_Puesto
        // ORANGE: 8, 9, 10, 11, 12 -> Integracion_Equipo
        // PURPLE: 13, 14, 15, 16, 17 -> Comprension_Org
        // BLUE: 18, 19, 21, 22 -> Efectividad_Onb
        
        $dimensions = [
            'Claridad' => ['m_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_claridad_procedimientos', 'm_contribucion_resultados'],
            'Cultura' => ['m_integracion_equipo', 'm_experiencia_colaboracion', 'm_conocimiento_cultura', 'm_alineacion_valores', 'm_percepcion_imagen'],
            'Liderazgo' => ['m_accesibilidad_jefe', 'm_retroalimentacion_jefe'],
            'Operaciones' => ['m_herramientas_trabajo', 'm_espacio_fisico', 'm_organizacion_induccion'],
            'Satisfacción' => ['m_atencion_rh', 'm_paquete_beneficios', 'm_proceso_administrativo', 'm_efectividad_onboarding', 'm_preparacion_capacitacion'],
            
            // Survey Dimensions (Cloud/Export)
            'Claridad_Puesto' => ['m_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_contribucion_resultados', 'm_experiencia_colaboracion'],
            'Integracion_Equipo' => ['m_accesibilidad_jefe', 'm_retroalimentacion_jefe', 'm_conocimiento_cultura', 'm_alineacion_valores', 'm_organizacion_induccion'],
            'Comprension_Org' => ['m_herramientas_trabajo', 'm_espacio_fisico', 'm_atencion_rh', 'm_paquete_beneficios', 'm_percepcion_imagen'],
            'Efectividad_Onb' => ['m_efectividad_onboarding', 'm_contribucion_resultados']
        ];

        $results = [];
        foreach ($dimensions as $name => $fields) {
            $sum = 0;
            foreach ($fields as $field) {
                $sum += isset($source[$field]) ? (int)$source[$field] : 0;
            }
            $avg = (count($fields) > 0) ? ($sum / (count($fields) * 10)) * 100 : 0;
            $results[$name] = round($avg, 0);
        }

        // Global IGEO Calculation (Numeric Only)
        $numericMetrics = [
            'm_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_preparacion_capacitacion',
            'm_efectividad_onboarding', 'm_contribucion_resultados', 'm_integracion_equipo',
            'm_experiencia_colaboracion', 'm_accesibilidad_jefe', 'm_retroalimentacion_jefe',
            'm_conocimiento_cultura', 'm_alineacion_valores', 'm_organizacion_induccion',
            'm_herramientas_trabajo', 'm_espacio_fisico', 'm_atencion_rh',
            'm_paquete_beneficios', 'm_percepcion_imagen'
        ];

        $globalSum = 0;
        foreach ($numericMetrics as $metric) {
            $globalSum += isset($source[$metric]) ? (int)$source[$metric] : 0;
        }
        $results['IGEO'] = round(($globalSum / (count($numericMetrics) * 10)) * 100, 0);

        return $results;
    }

    /**
     * Save evaluation to database
     */
    public function save($data) {
        if (!$this->db) {
            // SQL is bypassed in this environment (likely Vercel)
            return true;
        }

        if ($this->exists($data['num_empleado'])) {
            throw new Exception("El colaborador con ID {$data['num_empleado']} ya ha completado su evaluación.");
        }

        $fields = array_keys($data);
        $placeholders = array_map(function($f) { return ":$f"; }, $fields);
        
        $sql = "INSERT INTO onboarding_evaluations (" . implode(',', $fields) . ") 
                VALUES (" . implode(',', $placeholders) . ")";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function exists($num_empleado) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("SELECT id FROM onboarding_evaluations WHERE num_empleado = :num_empleado LIMIT 1");
        $stmt->execute(['num_empleado' => $num_empleado]);
        return $stmt->fetch() ? true : false;
    }

    public function filter($params) {
        if (!$this->db) {
            // Return empty set for SQL; Frontend will fetch from Firebase
            return [];
        }
        $sql = "SELECT * FROM onboarding_evaluations WHERE 1=1";
        $binds = [];

        // Support for Global Spotlight Search
        if (!empty($params['global'])) {
            $sql .= " AND (
                nombre LIKE :global OR 
                num_empleado LIKE :global OR 
                puesto LIKE :global OR 
                coordinacion LIKE :global OR
                f_logros LIKE :global OR
                f_mejoras_proceso LIKE :global OR
                f_comentarios_libres LIKE :global
            )";
            $binds['global'] = "%" . $params['global'] . "%";
        }

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

        if (!empty($params['date_start'])) {
            $sql .= " AND fecha_ingreso >= :date_start";
            $binds['date_start'] = $params['date_start'];
        }

        if (!empty($params['date_end'])) {
            $sql .= " AND fecha_ingreso <= :date_end";
            $binds['date_end'] = $params['date_end'];
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($binds);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate scores for each record to facilitate frontend charts
        foreach ($records as &$record) {
            $scores = $this->calculateScores($record);
            $record['IGEO'] = $scores['IGEO'];
            $record['scores'] = $scores;
        }

        return $records;
    }
}

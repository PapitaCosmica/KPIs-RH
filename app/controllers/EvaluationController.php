<?php
/**
 * Evaluation Controller - Phase 2
 * Handles business flow and request processing
 */

namespace App\Controllers;

use App\Models\Evaluation;
use Exception;

class EvaluationController {
    private $model;

    public function __construct() {
        $this->model = new Evaluation();
    }

    /**
     * Show list of evaluations (Dashboard View)
     */
    public function index() {
        $evaluations = $this->model->filter([]);
        // In a real MVC, we would pass this to a view
        return $evaluations;
    }

    /**
     * Store a new evaluation
     */
    public function store($postData) {
        try {
            $sanitizedData = [];
            
            // Basic fields sanitization
            $fields = ['num_empleado', 'nombre', 'puesto', 'coordinacion', 'fecha_ingreso'];
            foreach ($fields as $field) {
                $sanitizedData[$field] = filter_var($postData[$field] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            }

            // Metrics sanitization (Integer 1-10)
            for ($i = 1; $i <= 18; $i++) {
                // We map from generic post (m1...m18) to the DB naming in our model
                // For simplicity in this controller, we'll assume post names match DB names
                // but usually you'd have a mapping layer.
            }

            // Let's assume the POST arrives with the correct keys for simplicity in this Phase
            $metricsList = [
                'm_claridad_rol', 'm_bienvenida_equipo', 'm_herramientas', 'm_acceso_sistemas',
                'm_cultura', 'm_relacion_jefe', 'm_entorno_fisico', 'm_capacitacion',
                'm_procesos', 'm_objetivos', 'm_integracion_social', 'm_valores',
                'm_vision', 'm_beneficios', 'm_seguridad', 'm_soporte_rh',
                'm_calidad_induccion', 'm_expectativas'
            ];

            foreach ($metricsList as $m) {
                $val = (int)($postData[$m] ?? 0);
                $sanitizedData[$m] = ($val >= 1 && $val <= 10) ? $val : 0;
            }

            // Feedback fields
            $feedbackFields = ['f_comentarios_generales', 'f_sugerencias_mejora', 'f_obstaculos', 'f_lo_mejor', 'f_lo_peor'];
            foreach ($feedbackFields as $f) {
                $sanitizedData[$f] = filter_var($postData[$f] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            }

            // Call Model Save
            $success = $this->model->save($sanitizedData);

            if ($success) {
                return ['status' => 'success', 'message' => 'Evaluación guardada correctamente.'];
            }

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * JSON Endpoint for AJAX Search
     */
    public function apiSearch($params) {
        header('Content-Type: application/json');
        try {
            $results = $this->model->filter($params);
            echo json_encode(['status' => 'success', 'data' => $results]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }
}

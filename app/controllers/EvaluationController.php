<?php
/**
 * Evaluation Controller - Final Phase
 * Handles business flow for the 30-field survey
 */

namespace App\Controllers;

use App\Models\Evaluation;
use Exception;

class EvaluationController {
    private $model;

    public function __construct() {
        $this->model = new Evaluation();
    }

    public function index() {
        $evaluations = $this->model->filter([]);
        return $evaluations;
    }

    /**
     * Store a new evaluation (AJAX compatible)
     */
    public function store($postData) {
        try {
            $sanitizedData = [];
            
            // 1. Meta Fields (7)
            $metaFields = ['num_empleado', 'nombre', 'puesto', 'coordinacion', 'fecha_ingreso', 'fecha_realizacion', 'email'];
            foreach ($metaFields as $field) {
                $sanitizedData[$field] = filter_var($postData[$field] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            }

            // 2. Metrics (17)
            $metricsList = [
                'm_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_integracion_equipo',
                'm_experiencia_colaboracion', 'm_accesibilidad_jefe', 'm_retroalimentacion_jefe',
                'm_conocimiento_cultura', 'm_alineacion_valores', 'm_organizacion_induccion',
                'm_claridad_procedimientos', 'm_herramientas_trabajo', 'm_espacio_fisico',
                'm_atencion_rh', 'm_paquete_beneficios', 'm_proceso_administrativo',
                'm_percepcion_imagen', 'm_efectividad_onboarding'
            ];
            foreach ($metricsList as $m) {
                $val = (int)($postData[$m] ?? 0);
                $sanitizedData[$m] = ($val >= 1 && $val <= 10) ? $val : 0;
            }

            // 3. Feedback (6)
            $feedbackFields = [
                'f_utilidad_capacitaciones', 'f_faltantes_actividades', 'f_tiempo_onboarding',
                'f_satisfaccion_decision', 'f_mejoras_proceso', 'f_comentarios_libres'
            ];
            foreach ($feedbackFields as $f) {
                $sanitizedData[$f] = filter_var($postData[$f] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            }

            // Save
            $success = $this->model->save($sanitizedData);

            if ($success) {
                if (isset($postData['is_ajax'])) {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'success', 'message' => 'Evaluación enviada con éxito.']);
                    exit;
                }
                return ['status' => 'success', 'message' => 'Evaluación guardada correctamente.'];
            }

        } catch (Exception $e) {
            if (isset($postData['is_ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit;
            }
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

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

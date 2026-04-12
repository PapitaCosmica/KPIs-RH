<?php
/**
 * Evaluation Controller - Final Phase
 * Handles business flow for the 30-field survey
 */

namespace App\Controllers;

use App\Models\Evaluation;
use App\Models\Tunnel;
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

            // 2. Metrics (Total calculated for schema and form)
            $metricsList = [
                'm_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_preparacion_capacitacion',
                'm_integracion_equipo', 'm_experiencia_colaboracion', 'm_accesibilidad_jefe', 
                'm_retroalimentacion_jefe', 'm_conocimiento_cultura', 'm_alineacion_valores', 
                'm_organizacion_induccion', 'm_claridad_procedimientos', 'm_herramientas_trabajo', 
                'm_espacio_fisico', 'm_atencion_rh', 'm_paquete_beneficios', 'm_proceso_administrativo',
                'm_percepcion_imagen', 'm_efectividad_onboarding', 'm_contribucion_resultados'
            ];
            foreach ($metricsList as $m) {
                $val = (int)($postData[$m] ?? 0);
                $sanitizedData[$m] = ($val >= 1 && $val <= 10) ? $val : 0;
            }

            // 3. Feedback
            $feedbackFields = [
                'f_logros', 'f_utilidad_capacitaciones', 'f_faltantes_actividades', 
                'f_tiempo_onboarding', 'f_satisfaccion_decision', 'f_mejoras_proceso', 
                'f_comentarios_libres'
            ];
            foreach ($feedbackFields as $f) {
                $sanitizedData[$f] = filter_var($postData[$f] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            }

            // Save
            $success = $this->model->save($sanitizedData);

            if ($success) {
                // If this came from a tunnel, increment its usage
                if (!empty($postData['tunnel_token'])) {
                    $tunnelModel = new Tunnel();
                    $tunnelModel->incrementUsage($postData['tunnel_token']);
                }
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

    /**
     * API to create a new tunnel
     */
    public function createTunnel() {
        header('Content-Type: application/json');
        try {
            $maxResponses = (int)($_POST['max_responses'] ?? 1);
            $hours = (int)($_POST['hours'] ?? 24);

            $tunnelModel = new Tunnel();
            $token = $tunnelModel->create($maxResponses, $hours);

            if ($token) {
                // Load current public base URL from config
                $configPath = dirname(dirname(__DIR__)) . '/config/tunnel_config.php';
                $config = file_exists($configPath) ? include($configPath) : ['public_base_url' => URL_ROOT];
                $baseUrl = rtrim($config['public_base_url'], '/');
                
                // Use URL_ROOT to ensure subfolders like /KPIs-RH/public/ are included
                $url = $baseUrl . URL_ROOT . "?url=survey/tunnel&token=" . $token;
                echo json_encode(['status' => 'success', 'url' => $url]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al crear el túnel.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    /**
     * View the survey via a tunnel
     */
    public function viewTunnel() {
        $token = $_GET['token'] ?? '';
        $tunnelModel = new Tunnel();
        $tunnel = $tunnelModel->validate($token);

        if (!$tunnel) {
            die("Este túnel temporal ha expirado o ha alcanzado su límite de respuestas.");
        }

        // Setup variables for the view
        $isIsolated = true; // No header/sidebar
        $viewPath = VIEWS_PATH . '/evaluaciones/form.php';
        $tunnelToken = $token; // Pass to the view to include in the form
        
        include TEMPLATES_PATH . '/layout.php';
    }

    /**
     * API to update the global public base URL
     */
    public function updateTunnelBase() {
        header('Content-Type: application/json');
        try {
            $newBase = $_POST['base_url'] ?? '';
            if (empty($newBase)) throw new Exception("URL base vacía.");

            $configPath = dirname(dirname(__DIR__)) . '/config/tunnel_config.php';
            $content = "<?php\n\nreturn [\n    'public_base_url' => '$newBase'\n];";
            
            if (file_put_contents($configPath, $content)) {
                echo json_encode(['status' => 'success', 'message' => 'URL base actualizada.']);
            } else {
                throw new Exception("Error al escribir archivo de configuración.");
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }
}

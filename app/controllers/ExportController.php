<?php
/**
 * Export Controller - Phase 3
 * Handles file generation and downloads
 */

namespace App\Controllers;

use App\Models\Evaluation;
use App\Services\ExcelReport;

class ExportController {
    private $model;
    private $excelService;

    public function __construct() {
        $this->model = new Evaluation();
        $this->excelService = new ExcelReport();
    }

    /**
     * Download filtered evaluations in Excel format
     */
    public function download() {
        // 1. Get filters from GET
        $params = [
            'num_empleado' => $_GET['num_empleado'] ?? '',
            'nombre' => $_GET['nombre'] ?? '',
            'coordinacion' => $_GET['coordinacion'] ?? ''
        ];

        // 2. Fetch Data
        $data = $this->model->filter($params);

        // 3. Clear Buffer to avoid corruption
        if (ob_get_length()) ob_clean();

        // 4. Generate & Stream
        $spreadsheet = $this->excelService->generate($data);
        $this->excelService->stream($spreadsheet, 'Reporte_Onboarding_' . date('Ymd') . '.xlsx');
    }
}

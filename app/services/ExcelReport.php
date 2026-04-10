<?php
/**
 * ExcelReport Service - Phase 3
 * Generates professional reports using PhpSpreadsheet
 */

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExcelReport {
    private $spreadsheet;

    public function __construct() {
        $this->spreadsheet = new Spreadsheet();
    }

    /**
     * Map data to Excel and apply styling
     */
    public function generate($data) {
        $sheet = $this->spreadsheet->getActiveSheet();
        $sheet->setTitle('Evaluaciones Onboarding');

        // 1. Headers
        $headers = [
            'A1' => 'ID',
            'B1' => 'Num Empleado',
            'C1' => 'Nombre',
            'D1' => 'Puesto',
            'E1' => 'Coordinación',
            'F1' => 'Fecha Ingreso',
            'G1' => 'IGEO (%)'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFECEFF1'); // Gray
        }

        // 2. Data Insertion
        $row = 2;
        foreach ($data as $evaluation) {
            // Calculate IGEO on the fly or use pre-calculated (assuming model logic)
            // For this version, let's assume we pass the raw data and calculate here for visualization
            $totalSum = 0;
            $count = 18;
            $metrics = [
                'm_claridad_rol', 'm_bienvenida_equipo', 'm_herramientas', 'm_acceso_sistemas',
                'm_cultura', 'm_relacion_jefe', 'm_entorno_fisico', 'm_capacitacion',
                'm_procesos', 'm_objetivos', 'm_integracion_social', 'm_valores',
                'm_vision', 'm_beneficios', 'm_seguridad', 'm_soporte_rh',
                'm_calidad_induccion', 'm_expectativas'
            ];
            
            foreach ($metrics as $m) {
                $totalSum += (int)$evaluation[$m];
            }
            $igeo = round(($totalSum / ($count * 10)) * 100, 2);

            $sheet->setCellValue('A' . $row, $evaluation['id']);
            $sheet->setCellValue('B' . $row, $evaluation['num_empleado']);
            $sheet->setCellValue('C' . $row, $evaluation['nombre']);
            $sheet->setCellValue('D' . $row, $evaluation['puesto']);
            $sheet->setCellValue('E' . $row, $evaluation['coordinacion']);
            $sheet->setCellValue('F' . $row, $evaluation['fecha_ingreso']);
            $sheet->setCellValue('G' . $row, $igeo . '%');

            // 3. Semaforización (Conditional Formatting)
            $color = 'FF4CAF50'; // Green
            if ($igeo < 70) {
                $color = 'FFF44336'; // Red
            } elseif ($igeo < 85) {
                $color = 'FFFFC107'; // Yellow
            }

            $sheet->getStyle('G' . $row)->getFont()->getColor()->setARGB($color);
            $sheet->getStyle('G' . $row)->getFont()->setBold(true);

            $row++;
        }

        // 4. Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $this->spreadsheet;
    }

    /**
     * Final stream of the file
     */
    public function stream($spreadsheet, $filename = 'reporte_evaluaciones.xlsx') {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}

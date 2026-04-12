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
            // Calculate IGEO using the current 19 metrics
            $totalSum = 0;
            $count = 19;
            $metrics = [
                'm_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_preparacion_capacitacion',
                'm_integracion_equipo', 'm_experiencia_colaboracion', 'm_accesibilidad_jefe', 
                'm_retroalimentacion_jefe', 'm_conocimiento_cultura', 'm_alineacion_valores', 
                'm_organizacion_induccion', 'm_claridad_procedimientos', 'm_herramientas_trabajo', 
                'm_espacio_fisico', 'm_atencion_rh', 'm_paquete_beneficios', 'm_proceso_administrativo',
                'm_percepcion_imagen', 'm_efectividad_onboarding', 'm_contribucion_resultados'
            ];
            
            foreach ($metrics as $m) {
                $totalSum += (int)($evaluation[$m] ?? 0);
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

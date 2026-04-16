<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = 'docs/Efectividad del onboarding actualizada (version 2).xlsx';

if (!file_exists($file)) {
    die("File not found: $file\n");
}

try {
    $reader = IOFactory::createReader('Xlsx');
    $spreadsheet = $reader->load($file);
} catch (Exception $e) {
    die("Error loading file: " . $e->getMessage() . "\n");
}

$sheetNames = $spreadsheet->getSheetNames();
echo "Sheet names: " . implode(", ", $sheetNames) . "\n\n";

$sheet = $spreadsheet->getSheetByName('Datos');
if ($sheet) {
    echo "==================== SHEET: Datos (Detailed) ====================\n";
    for ($r = 1; $r <= 35; $r++) {
        $rowData = [];
        $cellIterator = $sheet->getRowIterator($r, $r)->current()->getCellIterator('A', 'AZ');
        foreach ($cellIterator as $cell) {
            $val = $cell->getValue();
            if (strpos($val, '=') === 0) {
                $rowData[] = "F(" . $cell->getCoordinate() . "): " . $val;
            } else {
                $rowData[] = $val;
            }
        }
        echo "Row $r: [" . implode(" | ", array_map(function($v){ return is_null($v) ? 'NULL' : (is_string($v) ? $v : json_encode($v)); }, $rowData)) . "]\n";
    }
}

<?php
require 'vendor/autoload.php';
$file = 'docs/Efectividad del onboarding actualizada (version 2).xlsx';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

echo "--- DATOS HEADERS ---\n";
$sheet = $spreadsheet->getSheetByName('Datos');
$headers = [];
$iter = $sheet->getRowIterator(1, 1)->current()->getCellIterator('A', 'AZ');
foreach ($iter as $cell) {
    if ($cell->getValue()) $headers[$cell->getColumn()] = $cell->getValue();
}
print_r($headers);

echo "\n--- HOJA1 ROWS 9-10 (Averages) ---\n";
$sheet = $spreadsheet->getSheetByName('Hoja1');
for ($r = 9; $r <= 10; $r++) {
    $iter = $sheet->getRowIterator($r, $r)->current()->getCellIterator('F', 'J');
    foreach ($iter as $cell) {
        $val = $cell->getValue();
        if (strpos($val, '=') === 0) {
            echo $cell->getCoordinate() . " => " . $val . "\n";
        }
    }
}

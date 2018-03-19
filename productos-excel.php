<?php
require_once './autoload.php';
require_once './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

$sheet->setTitle('Productos');

// Insertando una imagen
$drawing = new Drawing();
$drawing->setName('Tienda Online');
$drawing->setPath('img/logo.png');
$drawing->setHeight(50);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($sheet);

$sheet->setCellValue('A2', 'CODIGO');
$sheet->setCellValue('B2', 'CATEGORÍA');
$sheet->setCellValue('C2', 'NOMBRE');
$sheet->setCellValue('D2', 'PRECIO');
$sheet->setCellValue('E2', 'CREADO');

$productos = ProductoRepository::listar();

foreach ($productos as $i => $producto) {
    $sheet->setCellValueByColumnAndRow(1, $i+3, $producto->id);
    $sheet->setCellValueByColumnAndRow(2, $i+3, $producto->categorias_nombre);
    $sheet->setCellValueByColumnAndRow(3, $i+3, $producto->nombre);
    $sheet->setCellValueByColumnAndRow(4, $i+3, $producto->precio);
    $sheet->setCellValueByColumnAndRow(5, $i+3, $producto->creado);
}

// Definiendo anchos de columnas
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);

// Definiendo altos de filas
$sheet->getRowDimension(1)->setRowHeight(40);

// Combinando celdas
$sheet->mergeCells('A1:E1');

// Estilos
$sheet->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(Color::COLOR_BLACK);
$sheet->getStyle('A2:E2')->getFont()->setBold(true)->getColor()->setARGB(Color::COLOR_WHITE);
$sheet->getStyle('A2:E2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');

$row = $i+3;
$sheet->getStyle("D3:D$row")->getNumberFormat()->setFormatCode('"S/"#,##0.00_-');
$sheet->getStyle("A3:E$row")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Forzar descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="productos.xlsx"');
header('Cache-Control: max-age=0');

use PhpOffice\PhpSpreadsheet\IOFactory;
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

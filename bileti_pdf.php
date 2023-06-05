<?php
require('tfpdf/tfpdf.php');

// Получение данных представления из базы данных
$servername = "localhost";
$username = "yulyasc0_cirk";
$password = "Circus123";
$dbname = "yulyasc0_cirk";

$conn = new mysqli($servername, $username, $password, $dbname);
$viewId = $_GET['id']; // Получение идентификатора представления из параметра id

$sql = "SELECT * FROM perfomance WHERE id = '$viewId'";
$result = $conn->query($sql);
$selectedView = $result->fetch_assoc();

// Создание PDF-документа
$pdf = new tFPDF();
$pdf->AddPage();

$pdf->AddFont('DejaVuSans', '', 'DejaVuSans.ttf', true);
$pdf->SetFont('DejaVuSans', '', 12);

// Заголовки столбцов
$pdf->Cell(70, 10, 'Название представления', 1, 0, 'C');
$pdf->Cell(40, 10, 'Продано билетов', 1, 0, 'C');
$pdf->Cell(40, 10, 'Выручка', 1, 1, 'C');

// Данные из базы данных
$pdf->Cell(70, 10, $selectedView['title'], 1, 0, 'L');
$pdf->Cell(40, 10, $selectedView['kolichestvo_prodannix_biletov'], 1, 0, 'C');
$revenue = $selectedView['price'] * $selectedView['kolichestvo_prodannix_biletov'];
$pdf->Cell(40, 10, $revenue, 1, 1, 'C');
$totalRevenue = $revenue; // Установка общей выручки

// Вывод общей выручки
$pdf->SetFont('DejaVuSans', 'B', 12);
$pdf->Cell(190, 10, 'Общая выручка: ' . $totalRevenue, 0, 1, 'R');

$conn->close();

// Генерация временного имени файла
$tempFileName = 'afisha_' . $viewId . '.pdf';

// Сохранение PDF-документа на сервере
$pdf->Output($tempFileName, 'F');

// Установка заголовков для скачивания файла
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="afisha.pdf"');
header('Content-Length: ' . filesize($tempFileName));

// Чтение и вывод содержимого файла
readfile($tempFileName);

// Удаление временного файла
unlink($tempFileName);
?>

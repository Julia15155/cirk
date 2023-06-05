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

// Установка заднего фона
$pdf->SetFillColor(222, 246, 255);

// Вывод заднего фона на всю страницу
$pdf->Rect(0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight(), 'F');

// Вывод названия представления и дат проведения
$pdf->SetFont('DejaVuSans', '', 36);
$pdf->SetTextColor(36, 3, 252); // Установка цвета текста на красный
$pdf->SetXY(90, 30); // Установка позиции для вывода текста
$pdf->Cell(0, 10, 'Шоу ', 0, 1, 'L');
$pdf->SetXY(45, 45); // Установка позиции для вывода текста
$pdf->Cell(0, 10, $selectedView['title'], 0, 0, 'L', true); // Вывод текста с фоном

// Вывод даты начала представления слева от названия
$pdf->SetFont('DejaVuSans', '', 16);
$pdf->SetXY(10, 10); // Установка позиции для вывода текста
$start_date = date('d.m.Y', strtotime($selectedView['start_date'])); // Форматирование даты начала
$pdf->SetTextColor(123, 3, 252); // Установка цвета текста на красный
$pdf->Cell(0, 10, 'с ' . $start_date, 0, 1, 'L');

// Вывод даты окончания представления справа после названия
$pdf->SetFont('DejaVuSans', '', 16);
$pdf->SetXY(55, 10); // Установка позиции для вывода текста
$end_date = date('d.m.Y', strtotime($selectedView['end_date'])); // Форматирование даты окончания
$pdf->SetTextColor(123, 3, 252); // Установка цвета текста на красный
$pdf->Cell(0, 10, 'по ' . $end_date, 0, 0, 'R');


// Добавление изображения, если доступно
if (!empty($selectedView['image_url'])) {
    $imageWidth = $pdf->GetPageWidth() - 20; // Ширина изображения будет равна ширине страницы минус отступы
    $imageHeight = 0; // Высота изображения будет автоматически рассчитана
    $pdf->Image($selectedView['image_url'], 10, 70, $imageWidth, $imageHeight);
}

// Вывод описания представления
$pdf->SetFont('DejaVuSans', '', 18);
$pdf->SetTextColor(0, 0, 0); // Восстановление цвета текста
$pdf->SetXY(10, 195); // Установка позиции для вывода текста
$pdf->MultiCell(0, 10, $selectedView['description']);

// Вывод цены на представление
$pdf->SetFont('DejaVuSans', '', 24);
$pdf->SetXY(10, 240); // Установка позиции для вывода текста
$pdf->SetTextColor(0, 0, 0); // Восстановление цвета текста
$pdf->Cell(0, 10, 'Цена: ' . $selectedView['price'] . ' рублей', 0, 1, 'L');

// Вывод контактной информации посередине страницы
$pdf->SetFont('DejaVuSans', '', 14);
$contactInfo = 'Email: juliano122002@gmail.com | Телефон: 100-100-1515';
$contactInfoWidth = $pdf->GetStringWidth($contactInfo);
$contactInfoX = ($pdf->GetPageWidth() - $contactInfoWidth) / 2;
$pdf->SetXY($contactInfoX, ($pdf->GetPageHeight() - 37));
$pdf->Cell(0, 10, $contactInfo, 0, 1, 'C');
$pdf->SetX(10); // Установка позиции X для вывода следующей ячейки


// Генерация временного имени файла
$tempFileName = 'afisha_' . $viewId . '.pdf';

// Сохранение PDF-документа на сервере
$pdf->Output($tempFileName, 'F');

// Установка заголовков для скачивания файла
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="afisha.pdf"');

// Чтение и вывод содержимого файла
readfile($tempFileName);

// Удаление временного файла
unlink($tempFileName);

$conn->close();
?>

<?php
session_start();
require "conn.php";
require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (!isset($_SESSION['user_data'])) {
    header("Location: Index.php");
    exit;
}

$user = $_SESSION['user_data'];

 $correo = $user['upn'];

if (preg_match('/E\d+/', $correo, $matches)) {
    $qrData = $matches[0];
}

// Crear QR
$qrCode = new QrCode($qrData);
$qrCode->setSize(300);
$qrCode->setMargin(10);

$writer = new PngWriter();
$result = $writer->write($qrCode);

// Guardar QR
$qrPath = "qr_estudiante.png";
$result->saveToFile($qrPath);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>QR del estudiante</title>
</head>
<body>

<h1>QR del estudiante</h1>
<p><?php echo $user['name']; ?></p>

<img src="<?php echo $qrPath; ?>" alt="QR Code">
<p><?php echo $qrData; ?></p>

</body>
</html>
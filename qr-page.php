<?php
require "conn.php";
require "vendor/autoload.php";
require "Authenticate.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;





$qrData = $_SESSION['user_id'];

// Crear QR
$qrCode = QrCode::create($qrData)
    ->setSize(300)
    ->setMargin(10);

$writer = new PngWriter();
$result = $writer->write($qrCode);
$qrUri = $result->getDataUri();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>QR del estudiante</title>
<link  rel = 'stylesheet' href = 'style.css' >
</head>
<body>

<?php
include 'encabezado.php';
?>

<div class= 'general'>
<br><br>

<img src="<?php echo $qrUri; ?>" alt="QR Code">
<p><?php echo $qrData; ?></p>
<p><?php echo $_SESSION['user_name']; ?></p>

</div>
</body>
</html>
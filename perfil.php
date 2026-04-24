<?php 
    require "vendor/autoload.php";
    require "Authenticate.php";
    autorizarRoles(1, 2, 3);
    require "conn.php";
    include "navigation.php";
;

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

$stmt = $conectar->prepare("SELECT u.rol, r.Nombre FROM users u INNER JOIN rol r on u.rol = r.id_rol WHERE correo = :co");
$stmt->execute([':co' => $_SESSION['user_mail']]);
$user_data = $stmt->fetch();

    ?>
<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<head>
    <meta charset="UTF-8">
    
    <title>Perfil</title>
</head>
<body>

    

    <div class="admin-container ancho">
    <div class="admin-card">
        <div class="admin-avatar">
            <span>AD</span>
        </div>
        <figure>
        <img src="<?php echo $qrUri; ?>" alt="QR Code">
        </figure>
        <div class="admin-info">
            <h2 class="admin-name"><?php echo $_SESSION['user_name'] ?></h2>
            <span class="admin-role"><?php echo $user_data['Nombre'] ?></span>
            <p class="admin-email"><?php echo $_SESSION['user_mail'] ?></p>
            <a href="logout.php">Cerrar sesion <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </div>
    </div>
</div>
</div>
</body>
</html>
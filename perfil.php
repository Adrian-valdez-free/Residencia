<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<head>
    <meta charset="UTF-8">
    <?php 
    include "navigation.php";
    include "Authenticate.php";
    ?>
    <title>Perfil</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .json-container { background: #272822; color: #f8f8f2; padding: 15px; border-radius: 8px; overflow-x: auto; }
        .btn-logout { background: #d9534f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Datos recibidos de Microsoft Entra ID</h1>
    <p>Este es el contenido crudo del JSON que devuelve la API:</p>

    <div class="json-container">
        <pre><?php echo json_encode($_SESSION['user_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
    </div>

    <a href="logout.php" class="btn-logout">Cerrar Sesión (Logout)</a>

    <a href = "qr-page.php" class= "btn-logout"> Generar QR</a>
</body>
</html>
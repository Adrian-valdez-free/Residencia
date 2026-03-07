<?php
session_start();
require "conn.php";
// Si no hay sesión, lo mandamos al login
if (!isset($_SESSION['user_data'])) {
    header("Location: Index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
</body>
</html>
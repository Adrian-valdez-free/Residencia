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
    <link rel = 'stylesheet' href = 'style.css'>
    <style>
        body { font-family: sans-serif; background: #f4f4f4;}
    </style>
</head>
<body>

    <?php 
     include 'encabezado.php';
    ?>
   <br>

    <!--
   <div class="json-container">
   <pre><?php //echo json_encode($_SESSION['user_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
   </div>
    -->
   <div>

   <div class = 'fila menu'>
    <a class="boton_menu"  href="logout.php">Cerrar Sesión</a>

    <a class="boton_menu" href = "qr-page.php" > Generar QR</a>

    <a class="boton_menu" href ="inscribirse_actividad.php"> Incribirse a actividad</a>

    </div>

    <div class=" fila">

     <h2>PERFIL</h2>

    </div>

    </div>

</body>
</html>
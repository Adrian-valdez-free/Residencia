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

   <div>

   <div class = 'fila menu'>
    <a class="btn-delete"  href="logout.php">Cerrar Sesión</a>

    <a class="boton_menu" href = "qr-page.php" > Generar QR</a>

    <?php 
    ?>

    </div>

    <div class=" fila">

     <h2>PERFIL</h2>

    </div>

    </div>

</body>
</html>
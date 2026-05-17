<?php
session_start();

// Si la sesión existe, no lo dejamos estar en el Login
if (isset($_SESSION['user_mail'])) {
    
    // Lo ideal es mandarlo a su "casa" según su rol
    switch ($_SESSION['user_role']) {
        case 1:
            header("Location: dashboard-admin.php");
            break;
        case 2:
            header("Location: dashboard.php");
            break;
        case 3:
            header("Location: dashboard.php");
            break;
        default:
            // Por si algo raro pasa, lo mandamos a un inicio genérico
            header("Location: home.php");
            break;
    }
    exit(); // ¡Nunca olvides el exit!
}

// Si llega aquí, es porque NO tiene sesión y puede ver el login normalmente
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="mobiles.css">
  <link rel="stylesheet" href="tablet.css">
  
  <title>Sistema de control de eventos ITM</title>
</head>
<body>
  <div class="background">
    <div class="login ancho margen">
        <div class="box margen">
            <img class ="logo" src="assets/logo_tecnm.png" alt="logo"><br>
            <h2>Instituto Tecnologico de Merida</h2>
            <h3>Registro de eventos academicos</h3>
            <br>
            <a class = "microsoft" href="login.php"> <img src="assets/Microsoft-logo.svg" alt="">
            Inicia sesion con Microsoft
        </a><br>
        <p>Exclusivo para cuentas del <span class="fontweight">Instituto Tecnologico de Mérida</span></p>
        </div>
      </div>
    </div>
</body>
</html>
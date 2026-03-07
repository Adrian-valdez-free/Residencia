<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de control de eventos ITM</title>
</head>
<body>
  <h1>Sistema de control de eventos</h1>
  
  <?php if (isset($_SESSION['user_name'])): ?>
        <p>Bienvenido, <strong><?php echo $_SESSION['user_name']; ?></strong> (<?php echo $_SESSION['user_email']; ?>)</p>
        <a href="logout.php">Cerrar Sesión</a>
    <?php else: ?>
        <p>Para continuar, por favor inicia sesión con tu cuenta de la escuela.</p>
        <a href="login.php" style="background: #0078d4; color: white; padding: 10px; text-decoration: none;">
            Iniciar sesión con Microsoft Outlook
        </a>
    <?php endif; ?>
</body>
</html>
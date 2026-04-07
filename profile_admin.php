<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css">
  <title>Dashboard admin</title>
</head>
<body>
  
<div class="banner">
  <img src="assets/Logo TecNM.png" alt="logotec">
</div>
<div class="Main">
<?php 
include "sidebar.php";
?>
<div class="menu margen">
  <div class="admin-container">
    <div class="admin-card">
        <div class="admin-avatar">
            <span>AD</span>
        </div>

        <div class="admin-info">
            <h2 class="admin-name">Nombre del Admin</h2>
            <span class="admin-role">Super Administrador</span>
            <p class="admin-email">admin@itmerida.edu.mx</p>
        </div>

        <div class="admin-actions">
            <button class="btn-edit">Editar Perfil</button>
        </div>
    </div>
</div>
</div>
</div>
</body>
</html>
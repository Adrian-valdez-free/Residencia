<?php 
require "Authenticate.php";
autorizarRoles(1);
require "conn.php";

  $stmt = $conectar->prepare("SELECT u.rol, r.Nombre FROM users u INNER JOIN rol r on u.rol = r.id_rol WHERE correo = :co");
    $stmt->execute([':co' => $_SESSION['user_mail']]);
    $user_data = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="tablet.css">
  <link rel="stylesheet" href="mobile.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <title>Dashboard admin</title>
</head>
<body>
  
<div class="banner">
  <div class="logo">
  <img src="assets/Logo TecNM.png" alt="logotec">
  </div>
  <div class="resposive-boton">
    <img src="assets/Logo TecNM.png" alt="logotec">
      <a href="#" id ="boton_menu"><i class="fa-solid fa-bars"></i></a>
</div>
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
            <h2 class="admin-name"><?php echo $_SESSION['user_name'] ?></h2>
            <span class="admin-role"><?php echo $user_data['Nombre'] ?></span>
            <p class="admin-email"><?php echo $_SESSION['user_mail'] ?></p>
        </div>

        <!-- <div class="admin-actions">
            <button class="btn-edit">Editar Perfil</button>
        </div> -->
    </div>
</div>
</div>
</div>
<nav class ="nav-mobile" id="menu">
        <ul>
        <li><a class ="btn_ancla" href="dashboard-admin.php">Inicio<i class="fa-solid fa-gauge"></i></a></li>
        <li><a class ="btn_ancla" href="Events.php">Eventos<i class="fa-solid fa-clipboard-list"></i></a></li>
        <li><a class ="btn_ancla" href="Attendance.php">Asistencias<i class="fa-solid fa-clipboard-user"></i></a></li>
        <li><a class ="btn_ancla" href="list_users.php">Usuarios </a> <i class="fa-solid fa-people-roof"></i></i> </li>
        <li><a class ="btn_ancla" href="profile_admin.php">perfil<i class="fa-solid fa-user"></i></a></li>
        <li><a href="logout.php" class ="btn_ancla"><span class ="red"> Cerrar Sesion<i class="fa-solid fa-arrow-right-from-bracket"> </i> </span></a></li>

        </ul>
        <div class="boton_cerrar">
        <a href="#" class="btn_ancla"><i class="fa-solid fa-xmark"></i></a>
    </div>
      </nav>
<script>
  $('#boton_menu').click(function(e){
  $('#menu').toggleClass("abrir_Menu").removeClass("cerrar_menu");
  });

  $('.btn_ancla').click(function(){
    $("#menu").toggleClass("cerrar_menu").removeClass("abrir_Menu");
  }); 
</script>
</body>
</html>
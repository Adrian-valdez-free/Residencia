<?php
include "Authenticate.php";
autorizarRoles(1, 2, 3);
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
  <title>Document</title>
</head>
<body>
<?php 
include "navigation.php";
?>
<div class="hero margen">

</div>
<section class = "margen">
<div class="inner ancho margen"></div>
</section>
<nav class ="nav-mobile" id="menu">
        <ul>
        <li><a class ="btn_ancla" href="dashboard.php">Inicio<i class="fa-solid fa-house"></i></a></li>
        <li><a class ="btn_ancla" href="inscribirse_actividad.php">Inscripciones<i class="fa-solid fa-list-check"></i></a></li>
        <li><a class ="btn_ancla" href="schedchule-rol2.php">Horario<i class="fa-regular fa-calendar"></i></a></li>
        <li><?php if ((int)$_SESSION['user_role'] === 3): ?>
      <a class ="btn_ancla" href="leer_QR.php">Asistencia<i class="fa-solid fa-clipboard-user"></i></a>
      <?php endif; ?></li>
        <li><a class ="btn_ancla" href="perfil.php">perfil<i class="fa-solid fa-user"></i></a></li>
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

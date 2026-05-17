<?php 
require "Authenticate.php";
autorizarRoles(1, 2, 3);
require "conn.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tablet.css">
    <link rel="stylesheet" href="mobile.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
</head>
<body>

<?php include "navigation.php"; ?>

<div class="admin-container ancho">
  <h1>Calendario</h1>
    <div id="calendar-container">
        <div id="calendar"></div>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek', 
      slotMinTime: '07:00:00',     
      slotMaxTime: '20:00:00',     
      locale: 'es',                
      
      // ⚠️ OJO: Verifica si es get_evet.php o get_event.php
      events: 'get_evet.php', 
      
      eventColor: '#1a5276',
      height: 'auto' 
    });
    calendar.render();
  });
</script>

<nav class="nav-mobile" id="menu">
    <ul>
        <li><a class="btn_ancla" href="dashboard.php">Inicio<i class="fa-solid fa-house"></i></a></li>
        <li><a class="btn_ancla" href="inscribirse_actividad.php">Inscripciones<i class="fa-solid fa-list-check"></i></a></li>
        <li><a class="btn_ancla" href="schedchule-rol2.php">Horario<i class="fa-regular fa-calendar"></i></a></li>
        <li>
            <?php if ((int)$_SESSION['user_role'] === 3): ?>
                <a class="btn_ancla" href="leer_QR.php">Asistencia<i class="fa-solid fa-clipboard-user"></i></a>
            <?php endif; ?>
        </li>
        <li><a class="btn_ancla" href="perfil.php">perfil<i class="fa-solid fa-user"></i></a></li>
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
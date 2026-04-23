<?php 
    require "Authenticate.php";
    autorizarRoles(1, 2, 3);
    require "conn.php";
    include "navigation.php";
    ?>
<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

<head>
    <meta charset="UTF-8">
    
    <title>Horario</title>
</head>
<body>

<div class="admin-container ancho">

<div id='calendar-container'">
    <div id='calendar'></div>
</div>
 </div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek', // Vista de horario semanal
      slotMinTime: '07:00:00',     // Hora de inicio
      slotMaxTime: '20:00:00',     // Hora de fin
      locale: 'es',                // Idioma español
      
      // AQUÍ CARGAS TU BD
      events: 'get_evet.php', 
      
      eventColor: '#1a5276', // El azul institucional que usas en tu avatar
    });
    calendar.render();
  });
</script>


   
</body>
</html>
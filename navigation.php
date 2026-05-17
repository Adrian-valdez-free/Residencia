<nav class = "destopk-nav">
    <img src="assets/Logo TecNM.png" alt="logo">
    <div class="options">
      <a href="dashboard.php">Inicio<i class="fa-solid fa-house"></i></a>
      <a href="inscribirse_actividad.php">Inscripciones<i class="fa-solid fa-list-check"></i></a>
      <a href="schedchule-rol2.php">Horario<i class="fa-regular fa-calendar"></i></a>
      <?php if ((int)$_SESSION['user_role'] === 3): ?>
      <a href="leer_QR.php">Asistencia<i class="fa-solid fa-clipboard-user"></i></a>
      <?php endif; ?>
    </div>
    <div class="profile">
      <a href="perfil.php">perfil<i class="fa-solid fa-user"></i></a>
    </div>
    
</nav>
<div class="resposive-boton">
  <img src="assets/Logo TecNM.png" alt="logo">
      <a href="#" id ="boton_menu"><i class="fa-solid fa-bars"></i></a>
</div>
  <nav class = "">
    <img src="assets/Logo TecNM.png" alt="logo">
    <div class="options">
      <a href="dashboard.php">Inicio<i class="fa-solid fa-house"></i></a>
      <a href="#">Eventos</a>
      <a href="inscribirse_actividad.php">Inscripciones<i class="fa-solid fa-list-check"></i></a>
      <a href="schedchule-rol2.php">Horario<i class="fa-regular fa-calendar"></i></a>
      <?php if($_SESSION['user_role'] === 3)
        echo '<a href ="leer_QR.php">Asistencia<i class="fa-solid fa-clipboard-user"></i></a>'
        ?>
    </div>
    <div class="profile">
      <a href="perfil.php">perfil<i class="fa-solid fa-user"></i></a>
    </div>
  </nav>
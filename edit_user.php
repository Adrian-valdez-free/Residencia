<?php
session_start();
require "conn.php";

// 1. Verificar que venga un ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: dashboard-admin.php");
    exit();
}
try {
    $stmt = $conectar->prepare("SELECT * FROM users u INNER JOIN rol r ON u.rol = r.id_rol WHERE u.id_user = :id");
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch();

    // Si no existe ese evento
    if (!$user) {
        header("Location: list_users.php");
        exit();
    }
    $stmtRoles = $conectar->query("SELECT * FROM rol ORDER BY nombre ASC");
    $todos_los_roles = $stmtRoles->fetchAll();

} catch (PDOException $e) {
    echo "Error de SQL: " . $e->getMessage();
    exit();
    header("Location: list_users.php");
    exit();
}
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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
  <div class="title">
    <a href="list_users.php" class="btn-back">
      <i class="fa-solid fa-arrow-left"></i> Volver
    </a>
  <h1>Modificar rol</h1>
  </div>
  <form action="edit_new_user.php" id ="miFormulario"  method="post" onsubmit="return confirmarEdicion(event)">
  <input type="hidden" name="id" value="<?php echo $user['id_user']; ?>">

    <div class="midle">
    <div class="form_group">
    <label for="Name">Nombre del usuario</label>
    <input type="text" name="Name" value = "<?php echo htmlspecialchars($user['name']); ?>">
    </div>
  
<div class="form_group">
    <label for="Rol-id">Elige el rol</label>
    <select name="Rol" id="Rol-id">
        <option value="">-- Seleccione un rol --</option>
        <?php foreach ($todos_los_roles as $rol): ?>
            
            <?php if ((int)$rol['id_rol'] === 1) continue; ?>

            <option value="<?php echo $rol['id_rol']; ?>" 
                <?php 
                // Compara el ID del rol de la lista con el ID del rol que ya tiene asignado el usuario
                echo ($rol['id_rol'] == $user['id_rol']) ? 'selected' : ''; 
                ?>>
                <?php echo htmlspecialchars($rol['Nombre']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
    <div class="form_group">
    <label for="Name">Matricula</label>
    <input type="text" name="Expositor" value ="<?php echo htmlspecialchars($user['matricula']); ?>">
    </div>
    </div>
    <div class="midle">
     <div class="form_group">
    <label for="Capacidad">Correo</label>
    <input type="text" name="capacidad" id="capacidad" value ="<?php echo htmlspecialchars($user['correo']); ?>">
    </div>
     <div class="form_group">
    <label for="">Semestre</label>
    <input type="text" id="inicio" name="Inicio" value ="<?php echo htmlspecialchars($user['semestre']); ?>">
    </div>
     <div class="form_group">
    <label for="">Carrera</label>
    <input type="text" id="final" name="Final" value ="<?php echo htmlspecialchars($user['carrera']); ?>">
    </div>
     </div>
    <div class="button">
    <div class="button">
    <button type="submit">Cambiar rol</button>
</div>
    </div>
  </form>
<script>
// Guardamos los valores originales al cargar la página
const valoresOriginales = {
    rol: document.getElementById('Rol-id').value,
};

function confirmarEdicion(event) {
    event.preventDefault();

    const rolinput = document.getElementById('Rol-id').value;
    
    // 1. Validación de campos vacíos (Primero que nada)
    if (!rolinput.trim()) {
        Swal.fire("¡Espera!", "Faltan datos obligatorios por llenar", "warning");
        return false;
    }


    // 4. Comprobar si algo cambió
    const valoresActuales = {
        rolactual: rolinput
    };

   if (valoresOriginales.rol === rolinput) {
    Swal.fire("Sin cambios", "No has modificado ningún campo", "info");
    return false;
}

    // 5. Confirmación final
    Swal.fire({
        title: '¿Confirmar modificación?',
        text: "Se actualizarán el rol del estudiante en el sistema.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#002b70',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, guardar cambios',
        cancelButtonText: 'Revisar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('miFormulario').submit();
        }
    });
}
</script>
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
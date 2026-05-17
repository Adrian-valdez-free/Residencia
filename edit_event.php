<?php
include "Authenticate.php";
autorizarRoles(1);
require "conn.php";

// 1. Verificar que venga un ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: dashboard-admin.php");
    exit();
}
try {
    $stmt = $conectar->prepare("SELECT * FROM eventos INNER JOIN recinto r ON recintos_id = id_recinto WHERE id_evento = :id");
    $stmt->execute([':id' => $id]);
    $evento = $stmt->fetch();

    // Si no existe ese evento
    if (!$evento) {
        header("Location: Events.php");
        exit();
    }
    $stmtRecintos = $conectar->query("SELECT id_recinto, nombre_recinto FROM recinto ORDER BY nombre_recinto ASC");
    $todos_los_recintos = $stmtRecintos->fetchAll();

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: dashboard-admin.php");
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
    <a href="Events.php" class="btn-back">
      <i class="fa-solid fa-arrow-left"></i> Volver
    </a>
  <h1>Modificar evento</h1>
  </div>
  <form action="edit_new_event.php" id ="miFormulario"  method="post" onsubmit="return confirmarEdicion(event)">
  <input type="hidden" name="id" value="<?php echo $evento['id_evento']; ?>">

    <div class="midle">
    <div class="form_group">
    <label for="Name">Nombre del evento</label>
    <input type="text" name="Name" value = "<?php echo htmlspecialchars($evento['nombre_evento']); ?>">
    </div>
  
     <div class="form_group">
    <label for="recinto">Elige el recinto</label>
    <select name="recinto" id="Recinto-id">
        <option value="">-- Seleccione un recinto --</option>
        <?php foreach ($todos_los_recintos as $opcion): ?>
            <option value="<?php echo $opcion['id_recinto']; ?>" 
                <?php 
                // Si el ID del recinto en el bucle es igual al que ya tiene el evento, ponlo como 'selected'
                echo ($opcion['id_recinto'] == $evento['recintos_id']) ? 'selected' : ''; 
                ?>>
                <?php echo htmlspecialchars($opcion['nombre_recinto']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
    <div class="form_group">
    <label for="Name">Expositor</label>
    <input type="text" name="Expositor" value ="<?php echo htmlspecialchars($evento['ponente']); ?>">
    </div>
    </div>
    <div class="midle">
     <div class="form_group">
    <label for="Capacidad">Numero de asistentes (minimo 10 y maximo 150)</label>
    <input type="number" name="capacidad" id="capacidad" value ="<?php echo htmlspecialchars($evento['capacidad_e']); ?>">
    </div>
     <div class="form_group">
    <label for="">Fecha y hora de inicio</label>
    <input type="datetime-local" id="inicio" name="Inicio" value ="<?php echo date('Y-m-d\TH:i', strtotime($evento['hora_inicio'])); ?>">
    </div>
     <div class="form_group">
    <label for="">Fecha y hora de finalización</label>
    <input type="datetime-local" id="final" name="Final" value ="<?php echo date('Y-m-d\TH:i', strtotime($evento['hora_finalizar'])); ?>">
    </div>
     </div>
    <div class="form_groupt">
    <label for="Name">descripcion</label>
    <textarea type="text" name="descripcion" ><?php echo htmlspecialchars($evento['descripcion']); ?></textarea>
    </div>
    <div class="button">
    <button type="submit">Guardar cambios</button>
</div>
    </div>
  </form>
<script>
// Guardamos los valores originales al cargar la página
const valoresOriginales = {
    nombre: document.getElementsByName('Name')[0].value,
    recinto: document.getElementById('Recinto-id').value,
    expositor: document.getElementsByName('Expositor')[0].value,
    capacidad: document.getElementById('capacidad').value,
    inicio: document.getElementById('inicio').value,
    final: document.getElementById('final').value,
    descripcion: document.getElementsByName('descripcion')[0].value
};

function confirmarEdicion(event) {
    event.preventDefault();

    const inicioInput = document.getElementById('inicio').value;
    const finalInput = document.getElementById('final').value;
    const nombreInput = document.getElementsByName('Name')[0].value;
    const expositorInput = document.getElementsByName('Expositor')[0].value;
    const capacidadInput = document.getElementById('capacidad').value;
    const recintoInput = document.getElementById('Recinto-id').value;
    const descripcionInput = document.getElementsByName('descripcion')[0].value;

    // 1. Validación de campos vacíos (Primero que nada)
    if (!nombreInput.trim() || !recintoInput || !expositorInput.trim() || !capacidadInput || !inicioInput || !finalInput || !descripcionInput.trim()) {
        Swal.fire("¡Espera!", "Faltan datos obligatorios por llenar", "warning");
        return false;
    }

    // 2. Validación de capacidad
    if (parseInt(capacidadInput) < 10 || parseInt(capacidadInput) > 150) {
        Swal.fire("Capacidad inválida", "El cupo debe ser entre 10 y 150", "warning");
        return false;
    }

    // 3. Validación de fechas
    if (new Date(finalInput) <= new Date(inicioInput)) {
        Swal.fire({
            icon: 'warning',
            title: '¡Fechas inválidas!',
            text: 'La fecha de inicio debe ser antes que la de finalización'
        });
        return false;
    }

    // 4. Comprobar si algo cambió
    const valoresActuales = {
        nombre: nombreInput,
        recinto: recintoInput,
        expositor: expositorInput,
        capacidad: capacidadInput,
        inicio: inicioInput,
        final: finalInput,
        descripcion: descripcionInput
    };

    if (JSON.stringify(valoresOriginales) === JSON.stringify(valoresActuales)) {
        Swal.fire("Sin cambios", "No has modificado ningún campo", "info");
        return false;
    }

    // 5. Confirmación final
    Swal.fire({
        title: '¿Confirmar modificación?',
        text: "Se actualizarán los datos del evento en el sistema.",
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
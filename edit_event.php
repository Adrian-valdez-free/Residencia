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
    $stmt = $conectar->prepare("SELECT * FROM eventos WHERE id_evento = :id");
    $stmt->execute([':id' => $id]);
    $evento = $stmt->fetch();

    // Si no existe ese evento
    if (!$evento) {
        header("Location: Events.php");
        exit();
    }

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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <input type="text" name="Name" value = "<?php echo htmlspecialchars($evento['nombre']); ?>">
    </div>
  
     <div class="form_group">
    <label for="Name">Elige el recinto</label>
    <select name="recinto" id ="Recinto-id" value= "">
      <option value="<?php echo htmlspecialchars($evento['recinto']); ?>"><?php echo htmlspecialchars($evento['recinto']); ?></option>
      <option value="Auditorio Lic.">Auditorio Lic. Miguel Peon Toledo</option>
      <option value="H1">H1</option>
      <option value="H7">H7</option>
      <option value="H8">H8</option>
      <option value="H5">H5</option>
      </select>
      </div>
    <div class="form_group">
    <label for="Name">Expositor</label>
    <input type="text" name="Expositor" value ="<?php echo htmlspecialchars($evento['ponente']); ?>">
    </div>
    </div>
    <div class="midle">
     <div class="form_group">
    <label for="Capacidad">Numero de asistentes</label>
    <input type="number" name="capacidad" id="capacidad" value ="<?php echo htmlspecialchars($evento['capacidad']); ?>">
    </div>
     <div class="form_group">
    <label for="">Fecha y hora de inicio</label>
    <input type="datetime-local" id="inicio" name="Inicio" value ="<?php echo htmlspecialchars($evento['hora_inicio']); ?>">
    </div>
     <div class="form_group">
    <label for="">Fecha y hora de finalización</label>
    <input type="datetime-local" id="final" name="Final" value ="<?php echo htmlspecialchars($evento['hora_finalizar']); ?>">
    </div>
     </div>
    <div class="form_groupt">
    <label for="Name">descripcion</label>
    <textarea type="text" name="descripcion" ><?php echo htmlspecialchars($evento['descripcion']); ?></textarea>
    </div>
    <div class="button">
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

    // 1. Validación de fechas (Regla de negocio)
    if (new Date(finalInput) <= new Date(inicioInput)) {
       Swal.fire({
            icon: 'warning',
            title: '¡Fechas invalidas!',
            text: 'La fecha de inicio debe ser antes que la fecha de finalización',
            showConfirmButton: false
        });
        return false;
    }

    // 2. Comprobar si algo cambió (Optimización de costos)
    const valoresActuales = {
        nombre: document.getElementsByName('Name')[0].value,
        recinto: document.getElementById('Recinto-id').value,
        expositor: document.getElementsByName('Expositor')[0].value,
        capacidad: document.getElementById('capacidad').value,
        inicio: inicioInput,
        final: finalInput,
        descripcion: document.getElementsByName('descripcion')[0].value
    };

    // JSON.stringify es una forma rápida de comparar objetos simples
    const hayCambios = JSON.stringify(valoresOriginales) !== JSON.stringify(valoresActuales);

    if (!hayCambios) {
        Swal.fire("Sin cambios", "No se ha modificado ningun campo", "warning");
        return false; // Detiene el envío y ahorra recursos del servidor
    }

    // 3. Confirmación final
    Swal.fire({
        title: '¿Confirmar modificación?',
        text: "Se guardaran los cambios en el sistema.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#002b70',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, subir evento',
        cancelButtonText: 'Revisar'
    }).then((result) => {
        // 4. SI EL USUARIO DIJO QUE SÍ
        if (result.isConfirmed) {
            // Enviamos el formulario programáticamente
            document.getElementById('miFormulario').submit();
        }
    });
}
</script>
</div>
</div>
</body>
</html>
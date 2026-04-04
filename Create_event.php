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
  <h1>Agregar Nuevo evento</h1>
  </div>
  <form action="add_new_event.php" id ="miFormulario" method="post" onsubmit="return ejecutarvalidacion(event)">

    <div class="midle">
    <div class="form_group">
    <label for="Name">Nombre del evento</label>
    <input type="text" id = "Name" name="Name">
    </div>
  
     <div class="form_group">
    <label for="Name">Elige el recinto</label>
    <select name="recinto" id ="Recinto-id">
      <option value="" disable selected></option>
      <option value="Auditorio Lic.">Auditorio Lic. Miguel Peon Toledo</option>
      <option value="H1">H1</option>
      <option value="H7">H7</option>
      <option value="H8">H8</option>
      <option value="H5">H5</option>
      </select>
      </div>
    <div class="form_group">
    <label for="Name">Expositor</label>
    <input type="text" id = "Expositor" name="Expositor">
    </div>
    </div>
    <div class="midle">
     <div class="form_group">
    <label for="Capacidad">Numero de asistentes</label>
    <input type="number" name="capacidad" id="capacidad">
    </div>
     <div class="form_group">
    <label for="">Fecha y hora de inicio</label>
    <input type="datetime-local" id="inicio" name="Inicio">
    </div>
     <div class="form_group">
    <label for="">Fecha y hora de finalización</label>
    <input type="datetime-local" id="final" name="Final">
    </div>
     </div>
    <div class="form_groupt">
    <label for="Name">descripcion</label>
    <textarea type="text" id ="descripcion" name="descripcion"></textarea>
    </div>
    <div class="button">
    <button type="submit">Subir</button>
    </div>
  </form>
  <script>

function ejecutarvalidacion(event) {
    event.preventDefault();

    const valoresOriginales = {
    nombre: document.getElementsByName('Name')[0].value,
    recinto: document.getElementById('Recinto-id').value,
    expositor: document.getElementsByName('Expositor')[0].value,
    capacidad: document.getElementById('capacidad').value,
    Inicio: document.getElementById('inicio').value,
    Final: document.getElementById('final').value,
    descripcion: document.getElementsByName('descripcion')[0].value
    };

  const {nombre, recinto, expositor, capacidad, Inicio, Final, descripcion} = valoresOriginales;

  if( !nombre.trim() || !recinto.trim() || !expositor.trim() || !capacidad.trim() || !Inicio.trim() || !Final.trim() || !descripcion.trim()){
    Swal.fire("¡Espera!", "Faltan datos obligatorios", "warning");
        return false; // Se sale de la función y no hace nada más
  }

  event.preventDefault();
    const inicio = new Date(document.getElementById('inicio').value);
    const final = new Date(document.getElementById('final').value);

    if (final <= inicio) {
        Swal.fire({
            icon: 'warning',
            title: '¡Fechas invalidas!',
            text: 'La fecha de inicio debe ser antes que la fecha de finalización',
            showConfirmButton: false
        });
        return false; // Esto evita que el formulario se envíe
    }
    Swal.fire({
        title: '¿Confirmar registro?',
        text: "Se guardará el nuevo evento en el sistema.",
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

    return false; // Mantenemos el formulario pausado
}

</script>
</div>
</div>
</body>
</html>
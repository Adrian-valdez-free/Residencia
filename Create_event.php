<?php 
require "Authenticate.php";
require "conn.php";
try{
$stmt = $conectar->query("SELECT id_recinto, nombre_recinto FROM recinto");
$recintos = $stmt->fetchAll();
} catch (PDOException $e) {
  throw new PDOException($e->getMessage(), (int)$e->getCode());
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
      <?php foreach ($recintos as $opcion): ?>
        <option value="<?php echo $opcion['id_recinto']; ?>">
            <?php echo $opcion['nombre_recinto']; ?>
        </option>
    <?php endforeach; ?>
      </select>
      </div>
    <div class="form_group">
    <label for="Name">Expositor</label>
    <input type="text" id = "Expositor" name="Expositor">
    </div>
    </div>
    <div class="midle">
     <div class="form_group">
    <label for="Capacidad">Numero de asistentes (minimo 10 y maximo 150)</label>
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

    if(capacidad < 10 || capacidad > 150){
    Swal.fire("Capacidad invalida", "Minimo 10 o Maximo 150", "warning");
    return false;
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
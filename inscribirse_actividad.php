<?php
session_start();
require "conn.php";
// Si no hay sesión, lo mandamos al login
if (!isset($_SESSION['user_data'])) {
    header("Location: Index.php");
    exit;
}

$user = $_SESSION['user_data'];
 $correo = $user['upn'];
if (preg_match('/E\d+/', $correo, $matches)) {
    $matricula = $matches[0];
}


$stmt = $conectar->prepare("SELECT id_user FROM users WHERE matricula = ?");
$stmt->bind_param("s", $matricula); // Se pasa la variable
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $id_usuario = $row['id_user'];
} else {
    echo "Usuario no encontrado";
}

$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscribirse a actividad</title>
  <link rel ="stylesheet" href="style.css">
</head>
<body>
  <?php
    include "encabezado.php";
  ?>

<div class = "general">
 <h2 >Eventos disponbles</h2>
  
 <?php   
 require "conn.php";
 $BD = "SELECT * FROM eventos ORDER BY id_eventos ASC";         // Describimos la consulta en sql en una variable.
 $eventos = mysqli_query($conectar, $BD);                    //Extraemos los datos de la tabal de eventos en la BD
 if(mysqli_num_rows($eventos)>0) {             // Si el numero de evcentos en la tabla es mayor a 0 entonces...
    while($fila = $eventos->fetch_assoc()){   //Mostrar datos mientras existan filas por mostrar.
  ?>

  <div class = 'contenedor_eventos'>
       <div class = "mismalinea lado_izquierdo diseño_info_evento">
        <span class="texto_nom_evento"> <?php echo $fila['nombre_evento']; ?> </span> <br><br>
        <span>Conferencista: </span> <?php echo $fila['nombre_ponente']; ?> <br>
        <span>Horario: </span> <?php echo $fila['horario']; ?> <br>
        <span>Asistentes: </span> <?php echo $fila['asistentes']; ?>
       </div>

       <div class = 'mismalinea lado_derecho'>
         <?php
              $sql = "SELECT id_estudiante FROM tabla_registros_eventos WHERE id_estudiante = $id_usuario";
              $busqueda = $conectar->query($sql);
              if ($busqueda->num_rows > 0) { ?>
                
                <span>Inscrito</span>
                <?php } else{ ?>

                 <a href="" class="boton_eventos" href='#' onclick="validar('registrar_inscripcion.php?id_user=<?php echo $id_usuario; ?>&id_evento=<?php echo $fila['id_eventos']; ?>')">Inscribirse</a>
                            <?php } ?>

       </div>
       <div class='linea'></div>
       <br>
  </div>
  
<?php
    }
 }else{

   echo "Aun no hay eventos disponibles";
 }
?>


 
</div>


<script>
  function validar(url) {
    var confirma = confirm("Confirma inscripción al taller");
    if (confirma == true) {
      window.location = url;
    }
  }
</script>

</body>
</html>
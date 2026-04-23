<?php
require "conn.php"; // Se asume que $conectar es tu objeto PDO
require "Authenticate.php";
autorizarRoles(1, 2, 3);

$matricula = $_SESSION['user_id'];
try {
    // 2. Obtener ID de usuario con PDO
    $stmt = $conectar->prepare("SELECT id_user FROM users WHERE matricula = :mat");
    $stmt->execute([':mat' => $matricula]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $id_usuario = $usuario['id_user'];
    } else {
        die("Usuario no encontrado en la base de datos.");
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Error de base de datos al validar usuario.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <title>Inscribirse a actividad</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php 
include "navigation.php";
?>
<div class="container_events ancho margen">

  
  <?php    
  try {
      // 3. Consulta de eventos con PDO y Try-Catch
      $sql = "SELECT * FROM eventos ORDER BY id_evento ASC";
      $query_eventos = $conectar->query($sql);
      $eventos = $query_eventos->fetchAll(PDO::FETCH_ASSOC);

      if (count($eventos) > 0) { 
          foreach ($eventos as $fila) {
  ?>
            <div class='contenedor_eventos margen'>
                <div class="mismalinea lado_izquierdo diseño_info_evento">
                    <h1><?php echo htmlspecialchars($fila['nombre_evento']); ?></h1> <br>
                    <p>Conferencista: <?php echo htmlspecialchars($fila['ponente']); ?></p>
                    <p>Horario:  <?php echo date("d/m H:i", strtotime($fila['hora_inicio'])); ?> a <?php echo date("d/m H:i", strtotime($fila['hora_finalizar'])); ?> </p>
                    <p>Capacidad: <?php echo $fila['capacidad_e']; ?></p>
                </div>

                <div class='mismalinea lado_derecho'>
                    <?php
                    // Verificar si ya está inscrito
                    $sql_check = "SELECT id_estudiante FROM tabla_registros_eventos WHERE id_estudiante = :id_u AND id_evento = :id_e";
                    $stmt_check = $conectar->prepare($sql_check);
                    $stmt_check->execute([
                        ':id_u' => $id_usuario,
                        ':id_e' => $fila['id_evento']
                    ]);
                    
                    if ($stmt_check->fetch()) { ?>
                        <span style="color: green; font-weight: bold;">✔ Inscrito</span>
                    <?php } else { ?>
                        <a href="#" class="boton_eventos" onclick="validar('registrar_inscripcion.php?id_user=<?php echo $id_usuario; ?>&id_evento=<?php echo $fila['id_evento']; ?>')">Inscribirse</a>
                    <?php } ?>
                </div>
                <div class='linea'></div>
                <br>
            </div>
  <?php 
          } 
      } else {
          echo "<p>Aun no hay eventos disponibles en este momento.</p>";
      }
  } catch (PDOException $e) {
      error_log($e->getMessage());
      echo "<p>Lo sentimos, no se pudieron cargar los eventos en este momento.</p>";
  }
  ?>
</div>

<script>
  function validar(url) {
    Swal.fire({
        title: '¿Confirmar inscripción?',
        text: "Te registrarás en este evento.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#002b70', // El azul de tu diseño
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, inscribirme',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        // Si el usuario hace clic en el botón de confirmación
        if (result.isConfirmed) {
            // USAMOS LA URL QUE RECIBE LA FUNCIÓN
            window.location.href = url;
        }
    });
}
</script>
<?php if (isset($_GET['status'])): ?>
<script>
    const status = "<?php echo $_GET['status']; ?>";
    
    if (status === "success") {
        Swal.fire({
            icon: 'success',
            title: '¡Logrado!',
            text: 'Se ha registrado con exito.',
            timer: 2000,
            showConfirmButton: false,
        });
    } else if (status === "warning") {
        Swal.fire({
            icon: 'warning',
            title: 'Error',
            text: 'No puede registrarse dos veces',
            confirmButtonColor: '#002b70'
        });
    } else if (status === "succes_edit") {
        Swal.fire({
            icon: 'success',
            title: '¡Se ha modificado el evento!',
            text: 'El evento se modifico con exito',
            confirmButtonColor: '#002b70'
        });
    } else if (status === "error_db") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema con la base de datos.',
        });
    }
     window.history.replaceState({}, document.title, window.location.pathname)

</script>
<?php endif; ?>
</body>
</html>
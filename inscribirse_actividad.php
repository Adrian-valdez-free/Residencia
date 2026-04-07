<?php
require "conn.php"; // Se asume que $conectar es tu objeto PDO
require "Authenticate.php";

$matricula = $_SESSION['user_id'];
include "navigation.php";

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <title>Inscribirse a actividad</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php include "encabezado.php"; ?>

<div class="general">
  <h2>Eventos disponibles</h2>
  
  <?php    
  try {
      // 3. Consulta de eventos con PDO y Try-Catch
      $sql = "SELECT * FROM eventos ORDER BY id_evento ASC";
      $query_eventos = $conectar->query($sql);
      $eventos = $query_eventos->fetchAll(PDO::FETCH_ASSOC);

      if (count($eventos) > 0) { 
          foreach ($eventos as $fila) {
  ?>
            <div class='contenedor_eventos'>
                <div class="mismalinea lado_izquierdo diseño_info_evento">
                    <span class="texto_nom_evento"><?php echo htmlspecialchars($fila['nombre']); ?></span> <br><br>
                    <span>Conferencista: </span> <?php echo htmlspecialchars($fila['recinto']); ?> <br>
                    <span>Horario: </span> <?php echo htmlspecialchars($fila['hora_inicio']); ?> a <?php echo htmlspecialchars($fila['hora_finalizar']); ?> <br>
                    <span>Asistentes: </span> <?php echo $fila['capacidad']; ?>
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
    if (confirm("¿Confirmas tu inscripción a esta actividad?")) {
      window.location.href = url;
    }
  }
</script>

</body>
</html>
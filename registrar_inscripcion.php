<?php
require "conn.php"; 

if (!isset($_GET['id_user']) || !isset($_GET['id_evento'])) {
    header("Location: inscribirse_actividad.php");
    exit;
}

$id_user = $_GET['id_user'];
$id_evento = $_GET['id_evento'];
$asistencia = 0;

try {
    $sql = "INSERT INTO tabla_registros_eventos (id_evento, id_estudiante, asistencia) VALUES (:id_e, :id_u, :asis)";
    $stmt = $conectar->prepare($sql);
    
    $ejecutado = $stmt->execute([
        ':id_e' => $id_evento,
        ':id_u' => $id_user,
        ':asis' => $asistencia
    ]);

    if ($ejecutado) {
        header("Location: inscribirse_actividad.php?status=success");
        exit; // Siempre pon exit después de un header Location
    }

} catch (PDOException $e) {
    // 23000 = Violación de integridad (Ya está inscrito)
    if ($e->getCode() == 23000) {
        // CORRECCIÓN: Sin el 'echo' y agregamos el exit
        header("Location: inscribirse_actividad.php?status=warning");
        exit;
    } else {
        error_log("Error en inscripción: " . $e->getMessage());
        // Aquí sí usamos JS porque queremos mostrar un alert antes de mover al usuario
        echo '
        <script>
            alert("Hubo un error técnico al registrar tu asistencia.");
            window.location.href = "inscribirse_actividad.php";
        </script>
        ';
        exit;
    }
}

$stmt = null;
$conectar = null;
?>
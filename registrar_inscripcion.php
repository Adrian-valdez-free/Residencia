<?php
session_start();
require "conn.php"; // Se asume que $conectar es tu objeto PDO

// 1. Validar que los datos lleguen por la URL
if (!isset($_GET['id_user']) || !isset($_GET['id_evento'])) {
    header("Location: inscribirse_actividad.php");
    exit;
}

$id_user = $_GET['id_user'];
$id_evento = $_GET['id_evento'];

try {
    // 2. Preparar la inserción con PDO
    $sql = "INSERT INTO tabla_registros_eventos (id_evento, id_estudiante) VALUES (:id_e, :id_u)";
    $stmt = $conectar->prepare($sql);
    
    // 3. Ejecutar pasando los parámetros en un array
    $ejecutado = $stmt->execute([
        ':id_e' => $id_evento,
        ':id_u' => $id_user
    ]);

    if ($ejecutado) {
        echo '
        <script>
            alert("¡Inscripción exitosa! Te esperamos en el evento.");
            window.location.href = "inscribirse_actividad.php";
        </script>
        ';
    }

} catch (PDOException $e) {
    // 4. Manejo de errores específicos
    // El código 23000 es para violación de integridad (ej: registro duplicado)
    if ($e->getCode() == 23000) {
        echo '
        <script>
            alert("Ya te encuentras inscrito en este evento.");
            window.location.href = "inscribirse_actividad.php";
        </script>
        ';
    } else {
        error_log("Error en inscripción: " . $e->getMessage());
        echo '
        <script>
            alert("Hubo un error técnico al registrar tu asistencia.");
            window.location.href = "inscribirse_actividad.php";
        </script>
        ';
    }
}

// En PDO no es estrictamente necesario cerrar el statement, 
// pero puedes liberar la conexión así:
$stmt = null;
$conectar = null;
?>
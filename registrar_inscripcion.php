<?php

require "conn.php";

$id_user = $_GET['id_user'];
$id_evento = $_GET['id_evento'];


// Supongamos ya tienes $id_usuario y $id_evento
$stmt = $conectar->prepare("INSERT INTO tabla_registros_eventos (id_evento, id_estudiante) VALUES (?, ?)");
$stmt->bind_param("ii", $id_evento, $id_user); // "ii" = dos enteros
$ejecutado = $stmt->execute();

if ($ejecutado) {
    echo '
    <script>
        alert("Asistencia registrada correctamente");
        window.location.href = "inscribirse_actividad.php";
    </script>
    ';
} else {
    echo '
    <script>
        alert("Error al registrar asistencia");
        window.location.href = "inscribirse_acvtividad.php";
    </script>
    ';
}

$stmt->close();
$conectar->close();

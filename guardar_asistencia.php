<?php

require "conn.php";

$codigo = $_POST['codigo'];

$stmt = $conectar->prepare("SELECT id_user FROM users WHERE matricula = ?");
$stmt->bind_param("s", $codigo); // Se pasa la variable
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $id_usuario = $row['id_user'];
} else {
    echo "Usuario no encontrado";
}

$stmt->close();
// Recibir el QR



$sql = "SELECT id_estudiante FROM tabla_registros_eventos WHERE id_estudiante = $id_usuario";
$busqueda = $conectar->query($sql);

if ($busqueda->num_rows > 0) {

    //Si el usuario existe se actualiza la asistencia
    $stmt2 = $conectar->prepare("UPDATE tabla_registros_eventos SET asistencia = 1 WHERE id_estudiante = ?");
    $stmt2->bind_param("i", $id_usuario);
    $stmt2->execute();
    echo "Asistencia registrada para el usuario con matricula $codigo";
    $stmt2->close();

    echo "Asistencia registrada correctamente";
} else {
    echo "Error el estudiante con matricula $codigo NO ESTA INSCRITO para este eveto: " . $conectar->error;
}

$conectar->close();

?>
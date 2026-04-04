<?php

require "conn.php"; // Tu conexión PDO

$codigo = $_POST['codigo'];

try {
    // 1. Buscar el id_user
    $stmt = $conectar->prepare("SELECT id_user FROM users WHERE matricula = ?");
    $stmt->execute([$codigo]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $id_usuario = $row['id_user'];
    } else {
        echo "Usuario no encontrado";
        exit; // Detenemos para que no intente usar un $id_usuario inexistente abajo
    }

    // 2. Verificar si el estudiante está inscrito
    // Usamos prepare para mantener la seguridad de PDO
    $stmt_check = $conectar->prepare("SELECT id_estudiante FROM tabla_registros_eventos WHERE id_estudiante = ?");
    $stmt_check->execute([$id_usuario]);

    // rowCount() en PDO reemplaza a num_rows
    if ($stmt_check->rowCount() > 0) {

        // 3. Si el usuario existe se actualiza la asistencia
        $stmt2 = $conectar->prepare("UPDATE tabla_registros_eventos SET asistencia = 1 WHERE id_estudiante = ?");
        $stmt2->execute([$id_usuario]);
        
        echo "Asistencia registrada para el usuario con matricula $codigo";
        echo "Asistencia registrada correctamente";

    } else {
        // En PDO no existe $conectar->error, así que dejamos el mensaje limpio
        echo "Error el estudiante con matricula $codigo NO ESTA INSCRITO para este evento";
    }

} catch (PDOException $e) {
    // Si algo falla a nivel base de datos, lo capturamos aquí
    echo "Error en el sistema: " . $e->getMessage();
}

// Cerramos la conexión
$conectar = null;

?>
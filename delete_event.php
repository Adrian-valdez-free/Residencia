<?php
session_start();
require "conn.php";

// 1. Validar que el ID exista y sea un número
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: Events.php?status=error_id");
    exit();
}

try {
    // 2. Preparar la sentencia de eliminación
    $stmt = $conectar->prepare("DELETE FROM eventos WHERE id_evento = :id");
    
    // 3. Ejecutar
    $resultado = $stmt->execute([':id' => $id]);

    // 4. Verificar si realmente se borró algo (por si el ID no existía en la DB)
    if ($stmt->rowCount() > 0) {
        header("Location: Events.php?status=deleted");
    } else {
        header("Location: Events.php?status=not_found");
    }
    exit();

} catch (PDOException $e) {
    // Error de base de datos (por ejemplo, si el evento está ligado a otra tabla)
    error_log($e->getMessage());
    header("Location: Events.php?status=error_db");
    exit();
}
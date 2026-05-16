<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "conn.php";

try {
    $stmt = $conectar->prepare("SELECT 
    e.id_evento AS id, 
    e.nombre_evento AS title, 
    CONVERT(VARCHAR(19), hora_inicio, 120) AS start,
    CONVERT(VARCHAR(19), hora_finalizar, 120) AS [end],
    r.asistencia
FROM tabla_registros_eventos r
INNER JOIN eventos e ON r.id_evento = e.id_evento
INNER JOIN users u ON r.id_estudiante = u.id_user
WHERE u.correo = :co");

    $stmt->execute([':co' => $_SESSION['user_mail']]);
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ob_clean(); // <--- ESTO BORRA CUALQUIER ESPACIO O AVISO PREVIO
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($eventos);
    exit;
} catch (Exception $e) {
    // Enviar el error en formato JSON para poder verlo en la consola del navegador
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
<?php 
require "Authenticate.php";
 autorizarRoles(1, 2);
    require "conn.php";

try {
    $stmt = $conectar->prepare("SELECT 
    e.id_evento AS id, 
    e.nombre_evento AS title, 
    e.hora_inicio AS start, 
    e.hora_finalizar AS end,
    r.asistencia
FROM tabla_registros_eventos r
INNER JOIN eventos e ON r.id_evento = e.id_evento
INNER JOIN users u ON r.id_estudiante = u.id_user
WHERE u.correo = :co");
    $stmt->execute([':co' => $_SESSION['user_mail']]);
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($eventos);
} catch (Exception $e) {
    // Enviar el error en formato JSON para poder verlo en la consola del navegador
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
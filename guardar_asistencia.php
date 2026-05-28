<?php
// require "Authenticate.php";
// autorizarRoles(1, 2, 3);
require "conn.php";
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
    // 2. Verificar si el estudiante está inscrito (Simple: cualquier evento)
    $stmt_check = $conectar->prepare("SELECT id_estudiante FROM tabla_registros_eventos WHERE id_estudiante = ?");
    $stmt_check->execute([$id_usuario]);

    // REEMPLAZO DE rowCount(): Si fetch() devuelve datos, entramos al IF
    if ($stmt_check->fetch()) {

        // 3. Si existe se actualiza la asistencia
        $stmt2 = $conectar->prepare("UPDATE tabla_registros_eventos SET asistencia = 1 WHERE id_estudiante = ?");
        $stmt2->execute([$id_usuario]);
        
        if (ob_get_length()) ob_clean(); // Limpieza para que no se cuele el script de inactividad
        echo "✅ Asistencia registrada para matricula: $codigo";

    } else {
        if (ob_get_length()) ob_clean();
        echo "❌ Error: El estudiante $codigo NO está inscrito en ningún evento.";
    }

} catch (PDOException $e) {
    // Si algo falla a nivel base de datos, lo capturamos aquí
    echo "Error en el sistema: " . $e->getMessage();
}
$conectar = null;
?>
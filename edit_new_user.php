<?php
require "conn.php";

function sanitize(string $value): string {
    return htmlspecialchars(strip_tags(trim($value)));
}
$id_usuario  = sanitize($_POST['id']     ?? '');
$rol         = sanitize($_POST['Rol']  ?? '');


if(empty($rol)){
  exit("Faltan datos");
}

$stmt = $conectar->prepare('SELECT * FROM users WHERE id_user = :id');
    $stmt->execute([':id' => $id_usuario]);
    $usuario_actual = $stmt->fetch(PDO::FETCH_ASSOC);


if($usuario_actual['rol'] === $rol){
    header("Location: Events.php?msg=no_changes");
    exit();
   }


try {

$update = $conectar->prepare("UPDATE users SET rol = :rol WHERE id_user = :id");

$update->execute([
        ':rol' => $rol,
        ':id'  => $id_usuario // <--- ¡No olvides este!
    ]);
    
header("Location: list_users.php?status=succes_edit");
exit();
  } catch (PDOException $e) {
    error_log($e->getMessage());
    die("Error al actualizar datos");
}




<?php
require "conn.php";

function sanitize(string $value): string {
    return htmlspecialchars(strip_tags(trim($value)));
}
$id_evento     = sanitize($_POST['id']     ?? '');
$nombre_evento = sanitize($_POST['Name']     ?? '');
$recinto       = sanitize($_POST['recinto']  ?? '');
$ponente       = sanitize($_POST['Expositor']?? '');
$capacidad     = filter_input(INPUT_POST, 'capacidad', FILTER_VALIDATE_INT);
$fecha_hora_I  = sanitize($_POST['Inicio']   ?? '');
$fecha_hora_F  = sanitize($_POST['Final']    ?? '');
$descripcion   = sanitize($_POST['descripcion'] ?? '');
if(empty($nombre_evento) || empty($recinto) || empty($ponente) || !($capacidad) || empty($fecha_hora_I) || empty($fecha_hora_F) || empty($descripcion)){
  exit("Faltan datos");
}

$stmt = $conectar->prepare('SELECT * FROM eventos WHERE id_evento = :id');
    $stmt->execute([':id' => $id_evento]);
    $evento_actual = $stmt->fetch(PDO::FETCH_ASSOC);


if($evento_actual['nombre'] === $nombre_evento &&
   $evento_actual['recinto'] === $recinto       &&
   $evento_actual['ponente'] === $ponente      &&
   $evento_actual['capacidad'] === $capacidad &&
   $evento_actual['hora_inicio'] === $fecha_hora_I &&
   $evento_actual['hora_finalizar'] === $fecha_hora_F &&
   $evento_actual['descripcion'] === $descripcion
   ){
    header("Location: Events.php?msg=no_changes");
    exit();
   }

   $timestamp_I = strtotime($fecha_hora_I);
$timestamp_F = strtotime($fecha_hora_F);

if ($timestamp_F <= $timestamp_I) {
    exit("Error: La fecha de finalización debe ser posterior a la fecha de inicio.");
    header("Location: edit_event.php");
}


try {
$update = $conectar->prepare("UPDATE eventos SET 
nombre = :nom,
recinto = :rec,
ponente = :pon,
capacidad = :cap,
hora_inicio = :hori,
hora_finalizar = :horf,
descripcion = :des

WHERE id_evento = :id");

$update->execute([
        ':nom'  => $nombre_evento,
        ':rec'  => $recinto,
        ':pon'  => $ponente,
        ':cap'  => $capacidad,
        ':hori' => $fecha_hora_I,
        ':horf' => $fecha_hora_F,
        ':des'  => $descripcion,
        ':id'   => $id_evento
    ]);
header("Location: Events.php?status=succes_edit");
exit();
  } catch (PDOException $e) {
    error_log($e->getMessage());
    die("Error al actualizar datos");
}




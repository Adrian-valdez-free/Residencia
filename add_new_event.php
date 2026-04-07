<?php
require "conn.php";

function sanitize(string $value): string {
    return htmlspecialchars(strip_tags(trim($value)));
}


$nombre_evento = sanitize($_POST['Name']     ?? '');
$recinto       = sanitize($_POST['recinto']  ?? '');
$ponente       = sanitize($_POST['Expositor']?? '');
$capacidad     = filter_input(INPUT_POST, 'capacidad', FILTER_VALIDATE_INT);
$fecha_hora_I  = sanitize($_POST['Inicio']   ?? '');
$fecha_hora_F  = sanitize($_POST['Final']    ?? '');
$descripcion   = sanitize($_POST['descripcion'] ?? '');

$timestamp_I = strtotime($fecha_hora_I);
$timestamp_F = strtotime($fecha_hora_F);

if ($timestamp_F <= $timestamp_I) {
    exit("Error: La fecha de finalización debe ser posterior a la fecha de inicio.");
    header("Location: Events.php");
}

if(empty($nombre_evento) || empty($recinto) || empty($ponente) || !($capacidad) || empty($fecha_hora_I) || empty($fecha_hora_F) || empty($descripcion)){
  exit("Faltan datos");
}
try{

$stmt = $conectar->prepare('INSERT INTO eventos (nombre_evento, recintos_id, ponente, descripcion, hora_inicio, hora_finalizar, capacidad_e) VALUES (:nombre, :recinto, :ponente, :descripcion, :hora_inicio, :fecha_hora_F, :capacidad)');

        $stmt->execute([
            ':nombre'    => $nombre_evento,
            ':recinto'   => $recinto,
            ':capacidad' => $capacidad,
            ':ponente' => $ponente,
            ':descripcion' => $descripcion,
            ':hora_inicio' => $fecha_hora_I,
            ':fecha_hora_F' => $fecha_hora_F,

        ]);
        header("Location: Events.php?status=succes_add");

}catch (PDOException $e){
      error_log($e->getMessage()); 
    // getMessage() → obtiene el mensaje del error
    // error_log()  → lo guarda en los logs del servidor
    //                SOLO tú lo puedes ver, no el usuario

    echo "Error al crear el evento"; 
    // Mensaje limpio para el usuario, sin detalles técnicos

}

?>
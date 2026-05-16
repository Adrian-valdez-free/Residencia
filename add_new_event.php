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
    // Tip: El header debe ir ANTES del exit, si no, nunca se ejecuta
    header("Location: Events.php?status=error_date");
    exit("Error: La fecha de finalización debe ser posterior a la fecha de inicio.");
}

// --- EL TRUCO PARA AZURE SQL ---
// Convertimos los strings a formato ISO compatible con SQL Server
$fecha_sql_I = date("Y-m-d H:i:s", $timestamp_I);
$fecha_sql_F = date("Y-m-d H:i:s", $timestamp_F);

if(empty($nombre_evento) || empty($recinto) || empty($ponente) || !($capacidad) || empty($fecha_hora_I) || empty($fecha_hora_F) || empty($descripcion)){
  exit("Faltan datos");
}

try {
    $stmt = $conectar->prepare('INSERT INTO eventos (nombre_evento, recintos_id, ponente, descripcion, hora_inicio, hora_finalizar, capacidad_e) VALUES (:nombre, :recinto, :ponente, :descripcion, :hora_inicio, :fecha_hora_F, :capacidad)');

    $stmt->execute([
        ':nombre'       => $nombre_evento,
        ':recinto'      => $recinto,
        ':capacidad'    => $capacidad,
        ':ponente'      => $ponente,
        ':descripcion'  => $descripcion,
        ':hora_inicio'  => $fecha_sql_I, // <--- USA LAS VARIABLES FORMATEADAS
        ':fecha_hora_F' => $fecha_sql_F, // <--- USA LAS VARIABLES FORMATEADAS
    ]);

    header("Location: Events.php?status=succes_add");
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage()); 
    echo "Error al crear el evento: " . $e->getMessage(); // Agrégale esto temporalmente para ver si sale otro error
}
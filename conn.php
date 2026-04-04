<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "sistema_control";
$cotejamiento = "utf8mb4";

try {
    $conectar = new PDO(
        "mysql:host=$host;dbname=$basedatos;charset=utf8mb4",
        $usuario,
        $contrasena,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    error_log($e->getMessage());
    die("No se pudo conectar al servidor");
}
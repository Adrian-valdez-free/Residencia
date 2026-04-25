<?php


$host      = getenv("DB_HOST");
$usuario   = getenv("DB_USER");
$contrasena = getenv("DB_PASS");
$basedatos  = getenv("DB_NAME");
$cotejamiento = "utf8mb4";

try {
    $conectar = new PDO(
        "sqlsrv:Server=$host,1433;Database=$basedatos;Encrypt=yes;TrustServerCertificate=no",
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

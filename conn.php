<?php

$host = getenv("DB_HOST");
$usuario = getenv("DB_USER");
$contrasena = getenv("DB_PASS");
$basedatos = getenv("DB_NAME");
$cotejamiento = "utf8mb4";
$conectar = mysqli_init();

// Configurar SSL (Azure lo requiere)
mysqli_ssl_set($conectar, NULL, NULL, NULL, NULL, NULL);

mysqli_real_connect(
    $conectar,
    $host,
    $usuario,
    $contrasena,
    $basedatos,
    3306,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!$conectar) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>

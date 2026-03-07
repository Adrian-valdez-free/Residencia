<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "sistema_control";
$cotejamiento = "utf8mb4";

$conectar = mysqli_connect($host, $usuario, $contrasena, $basedatos);

if (!$conectar) {
  echo "No se pudo conectar con el servidor";
}
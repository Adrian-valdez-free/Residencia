<?php
session_start();
require "conn.php";

// Si no hay sesión, lo mandamos al login
if (!isset($_SESSION['user_mail'])) {
    header("Location: Index.php");
    exit();
}

// try {
//     $stmt = $conectar->prepare('SELECT rol FROM users WHERE correo = :correo');
//     $stmt->execute([':correo' => $_SESSION['user_mail']]);
    
//     $usuario = $stmt->fetch();

//     if (!$usuario) {
//         // El correo no existe en la BD
//         session_destroy();
//         header("Location: Index.php");
//         exit();
//     }

//     $rol = $usuario['rol'];

//     if ($rol === 1) {
//         header("Location: dashboard-admin.php");
//     } else {
//         header("Location: dashboard.php");
//     }
//     exit();

// } catch (PDOException $e) {
//     error_log($e->getMessage());
//     die("Error al verificar usuario");
// }
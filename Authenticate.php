<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "conn.php";

function autorizarRoles(...$rolesPermitidos) {
    // 1. Verificación de Autenticación
    if (!isset($_SESSION['user_mail'])) {
        header("Location: Index.php?error=no_sesion");
        exit();
    }

    // 2. Verificación de Autorización
    if (!in_array($_SESSION['user_role'], $rolesPermitidos)) {
        header("Location: denied_acces.php");
        exit();
    }

    // Si llegó aquí, el usuario es válido. 
    // Ahora sí podemos imprimir el JS de inactividad.
    ?>
    <script>
        (function() {
            const TIEMPO_LIMITE = 600000; 
            let timer;
            const reiniciarContador = () => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    window.location.href = 'logout.php?status=inactivity';
                }, TIEMPO_LIMITE);
            };
            window.onmousemove = reiniciarContador;
            window.onkeypress = reiniciarContador;
            window.onmousedown = reiniciarContador;
            window.onclick = reiniciarContador;
            window.onscroll = reiniciarContador;
            reiniciarContador();
        })();
    </script>
    <?php 
}

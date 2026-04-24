<?php
session_start();
require "conn.php";

/**
 * Protege el acceso a una página basándose en la sesión y el rol del usuario.
 * * @param int ...$rolesPermitidos Lista de IDs de roles que tienen permiso (ej. 1, 2).
 * @return void Redirige y finaliza la ejecución si no se cumplen los requisitos.
 */
function autorizarRoles(...$rolesPermitidos) {
    // 1. Verificación de Autenticación
    if (!isset($_SESSION['user_mail'])) {
        header("Location: Index.php?error=no_sesion");
        exit();
    }

    // 2. Verificación de Autorización (Nivel de Acceso)
    if (!in_array($_SESSION['user_role'], $rolesPermitidos)) {
        header("Location: denied_acces.php");
        exit();
    }
    ?>
    <script>
        (function() {
            // 10 minutos de inactividad (600,000 milisegundos)
            const TIEMPO_LIMITE = 10000; 
            let timer;

            const reiniciarContador = () => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    window.location.href = 'logout.php?status=inactivity';
                }, TIEMPO_LIMITE);
            };

            // Eventos que reinician el tiempo
            window.onmousemove = reiniciarContador;
            window.onkeypress = reiniciarContador;
            window.onmousedown = reiniciarContador;
            window.onclick = reiniciarContador;
            window.onscroll = reiniciarContador;
            
            reiniciarContador(); // Iniciar el conteo al cargar
        })();
    </script>
    <?php 
}
?>
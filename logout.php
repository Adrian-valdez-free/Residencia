<?php
session_start();

// 1. Limpiar todas las variables de sesión
$_SESSION = array();

// 2. Destruir la sesión físicamente
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
      session_name(), '',
       time() - 42000,

        $params["path"],
         $params["domain"],
        $params["secure"],
         $params["httponly"]
    );
}


session_destroy();

$microsoftLogout = "https://login.microsoftonline.com/common/oauth2/v2.0/logout?post_logout_redirect_uri=http://localhost/Residencia/Index.php";
header("Location: " . $microsoftLogout);

// 3. Redirigir al Index
header("Location: Index.php");
exit;
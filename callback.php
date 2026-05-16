<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'vendor/autoload.php';
require 'conn.php';
require 'load_env.php';

$clientSecret = getenv('AZURE_CLIENT_SECRET');
$clientId = getenv('AZURE_CLIENT_ID');
$Tenant_id = getenv('AZURE_TENANT_ID');
$Callback = getenv('AZURE_CALLBACK_URL');

$provider = new TheNetworg\OAuth2\Client\Provider\Azure([
    'clientId'     => $clientId,
    'clientSecret' => $clientSecret,
    'redirectUri'  => $Callback,
]);

if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    exit('Estado inválido');
}

try {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    $resourceOwner = $provider->getResourceOwner($token);
    $data = $resourceOwner->toArray();

    $nombre = $data['name'];
    $email  = $data['upn'];

    // Lógica de matrícula
    $ND = explode('@', $email)[0];
    $numeromat = substr($ND, 2);

    // 1. Buscamos si el usuario ya existe (USANDO $conectar)
    $stmt = $conectar->prepare("SELECT * FROM users WHERE correo = :co");
    $stmt->execute([':co' => $email]);
    $user_data = $stmt->fetch();

    if($user_data){
        // Usuario ya existe, actualizamos sesión y redirigimos
        $_SESSION['user_mail'] = $data['upn'];
        $_SESSION['user_name'] = $data['name'];
        $_SESSION['user_role'] = $user_data['rol'];

        if($user_data['rol'] == "1"){
            $_SESSION['user_mail'] = $email;
            $_SESSION['user_name'] = $nombre;
            $_SESSION['user_role'] = $user_data['rol'];
            header("Location: dashboard-admin.php");
        } else {
            $_SESSION['user_mail'] = $email;
            $_SESSION['user_name'] = $nombre;
            $_SESSION['user_role'] = $user_data['rol'];
            $_SESSION['user_id'] = $user_data['matricula'];
            header("Location: dashboard.php");
        }
        exit; // <--- IMPORTANTE: Detener ejecución tras redirección
    }

    // 2. Si no existe, determinamos el rol para el registro nuevo
    if(ctype_digit(substr($numeromat, 0, 1))) {
        $matricula = explode('@', substr($email, 1))[0];
        $rol = 2;
    } else {
        $rol = 1;
        $matricula = "";
    }

    // 3. INSERTAR NUEVO USUARIO (Ajustado para ser compatible con SQL Server)
    // Nota: Si usas MySQL, puedes dejar tu ON DUPLICATE KEY. 
    // Si usas Azure SQL, este INSERT simple funcionará porque ya validamos arriba que no existe.
    $sql = "INSERT INTO users (name, correo, matricula, rol) VALUES (:nom, :em, :mat, :rol)";

    $stmt = $conectar->prepare($sql); // <--- CAMBIADO DE $pdo A $conectar
    $stmt->execute([
        ':nom' => $nombre,
        ':em'  => $email,
        ':mat' => $matricula,
        ':rol' => $rol,
    ]);

    // Configurar sesión para el nuevo registro
    $_SESSION['user_mail'] = $email;
    $_SESSION['user_name'] = $nombre;
    $_SESSION['user_id'] = $matricula;
    $_SESSION['user_role'] = $rol;

    if($rol == 1){
        header("Location: dashboard-admin.php");
    } else {
        header("Location: dashboard.php");
    }
    exit;
    
} catch (Exception $e) {
    exit('Error: ' . $e->getMessage());
}
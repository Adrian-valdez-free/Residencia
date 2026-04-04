<?php
session_start();
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

    // Obtener datos del alumno
    $resourceOwner = $provider->getResourceOwner($token);
    $data = $resourceOwner->toArray();


    $dsn = "mysql:host=$host;dbname=$basedatos;charset=$cotejamiento";
    $pdo = new PDO($dsn, $usuario, $contrasena);

    $nombre = $data['name'];
    $email  = $data['upn'];

    $ND = explode('@', $email)[0];
    $numeromat = substr($ND, 2);

    $stmt = $conectar->prepare("SELECT * FROM users WHERE correo = :co");
    $stmt->execute([':co' => $email]);
    $user_data = $stmt->fetch();

    if($user_data){
        if($user_data['rol'] != "1"){
        $_SESSION['user_mail'] = $data['upn'];
        $_SESSION['user_name'] = $data['name'];
        $_SESSION['user_id'] = $user_data['matricula'];
        header("Location: dashboard.php");
        session_start();
        exit;
        }else{
        $_SESSION['user_data'] = $data;
        $_SESSION['user_mail'] = $data['upn'];
        $_SESSION['user_name'] = $data['name'];
        header("Location: dashboard-admin.php"); 
        session_start();
        exit;// Lo mandamos al nuevo archiv
        }
    }

        if(ctype_digit(substr($numeromat, 0, 1)))
        {
        //Hay un numero dentro del correo en la tercera posición, entonces es alumno
        $matricula_con_dominio = substr($email, 1);
        $partes = explode('@', $matricula_con_dominio);
        $matricula = $partes[0];
        $rol = 2;
        $_SESSION['user_mail'] = $data['upn'];
        $_SESSION['user_name'] = $data['name'];
        $_SESSION['user_id'] = $matricula;
        session_start();
    }else{
        //el correo no tiene un numero en la tercera posición, 
        $rol = 1;
        $matricula = "";
        $_SESSION['user_data'] = $data;
        $_SESSION['user_mail'] = $data['upn'];
        $_SESSION['user_name'] = $data['name'];
        session_start();
    }

    $sql = "INSERT INTO users (name, correo, matricula, rol) 
            VALUES (:nom, :em, :mat, :rol)
            ON DUPLICATE KEY UPDATE correo= :em ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nombre,
        ':em'  => $email,
        ':mat' => $matricula,
        ':rol' => $rol
    ]);
    if($rol != 1){
    header("Location: dashboard.php");
    session_start(); // Lo mandamos al nuevo archivo
    exit;
    }else{
         header("Location: dashboard-admin.php"); 
         session_start();// Lo mandamos al nuevo archivo
    }
    
} catch (Exception $e) {
    exit('Error: ' . $e->getMessage());
}
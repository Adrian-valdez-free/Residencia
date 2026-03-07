<?php
session_start();
require 'vendor/autoload.php';
require 'load_env.php';

$clientSecret = getenv('AZURE_CLIENT_SECRET');
$clientId = getenv('AZURE_CLIENT_ID');
$Tenant_id = getenv('AZURE_TENANT_ID');
$Callback = getenv('AZURE_CALLBACK_URL');

$provider = new TheNetworg\OAuth2\Client\Provider\Azure([
    'clientId'          => $clientId,
    'clientSecret'      => $clientSecret,
    'redirectUri' => $Callback,
    'defaultEndPoint'   => $Tenant_id, 
]);

$authUrl = $provider->getAuthorizationUrl([
    'prompt' => 'select_account' // Esto obliga a Microsoft a mostrar la lista de cuentas o pedir login
]);

$_SESSION['oauth2state'] = $provider->getState();
header('Location: ' . $authUrl);
exit;
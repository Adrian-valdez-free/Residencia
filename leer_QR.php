<?php
include "Authenticate.php";
autorizarRoles(1, 3);
include 'navigation.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leer QR</title>
  <link rel = stylesheet href = 'style.css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Librería para leer QR -->
  <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
    
<div class="admin-container ancho">

    <h1>Tomar asistencia</h1>
  <!-- Contenedor de la cámara -->

  <div id="reader"></div>

  <!-- Resultado del QR -->
  <div id="resultado" style="font-weight:bold; font-size:18px;"></div>

</div>
  <!-- JavaScript para escanear QR -->
<script>
function onScanSuccess(decodedText) {

    document.getElementById("resultado").innerHTML = "QR detectado: " + decodedText;

    // Enviar el dato a PHP
    fetch("guardar_asistencia.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "codigo=" + encodeURIComponent(decodedText)
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("resultado").innerHTML += "<br>" + data;
    });

    // Detener cámara después de leer
    //html5QrcodeScanner.clear();
}

function onScanFailure(error) {}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 500 }
);

html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

</body>
</html>
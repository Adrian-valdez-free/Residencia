<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leer QR</title>
  <link rel = stylesheet href = 'style.css'>
  <!-- Librería para leer QR -->
  <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
    <?php
    include 'encabezado.php';
    ?>

    <div class = 'div_leer_qr'>

     
  <h1>Lector QR</h1>
  <!-- Contenedor de la cámara -->
  <div id="reader" style="width:300px; margin-bottom: 20px;"></div>

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
    html5QrcodeScanner.clear();
}

function onScanFailure(error) {}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 }
);

html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

</body>
</html>
<?php
include "Authenticate.php";
autorizarRoles(1, 3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leer QR</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tablet.css">
    <link rel="stylesheet" href="mobile.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include 'navigation.php'; ?>
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

    //Detiene el scaneo por un momento
    html5QrcodeScanner.pause(true);

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
        if (data.includes("✅")) {
            // ALERTA DE ÉXITO
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia Registrada!',
                text: data,
                timer: 2500, // Se cierra sola en 2.5 segundos
                showConfirmButton: false
            }).then(() => {
                // Reanudamos la cámara automáticamente al cerrarse la alerta
                html5QrcodeScanner.resume();
            });
        } else {
            // ALERTA DE ERROR
            Swal.fire({
                icon: 'error',
                title: 'Error de Registro',
                text: data,
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#002b70' // Tu azul institucional
            }).then(() => {
                // Reanudamos la cámara al dar clic en aceptar
                html5QrcodeScanner.resume();
            });
        }
    })
    
}

function onScanFailure(error) {}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 400 }
);

html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
<nav class="nav-mobile" id="menu">
    <ul>
        <li><a class="btn_ancla" href="dashboard.php">Inicio<i class="fa-solid fa-house"></i></a></li>
        <li><a class="btn_ancla" href="inscribirse_actividad.php">Inscripciones<i class="fa-solid fa-list-check"></i></a></li>
        <li><a class="btn_ancla" href="schedchule-rol2.php">Horario<i class="fa-regular fa-calendar"></i></a></li>
        <li>
            <?php if ((int)$_SESSION['user_role'] === 3): ?>
                <a class="btn_ancla" href="leer_QR.php">Asistencia<i class="fa-solid fa-clipboard-user"></i></a>
            <?php endif; ?>
        </li>
        <li><a class="btn_ancla" href="perfil.php">perfil<i class="fa-solid fa-user"></i></a></li>
    </ul>
    <div class="boton_cerrar">
        <a href="#" class="btn_ancla"><i class="fa-solid fa-xmark"></i></a>
    </div>
</nav>

<script>
    $('#boton_menu').click(function(e){
        $('#menu').toggleClass("abrir_Menu").removeClass("cerrar_menu");
    });

    $('.btn_ancla').click(function(){
        $("#menu").toggleClass("cerrar_menu").removeClass("abrir_Menu");
    }); 
</script>
</body>
</html>
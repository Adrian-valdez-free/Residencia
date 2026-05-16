<?php 
require "Authenticate.php";
autorizarRoles(1);
require "conn.php";

try {
    // Consulta para obtener todos los usuarios
    $query = $conectar->query("SELECT * FROM users u INNER JOIN rol r on u.rol = r.id_rol ORDER BY id_user DESC");
    $users = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log($e->getMessage());
    $users = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <title>Dashboard admin</title>

</head>
<body>
  
<div class="banner">
  <img src="assets/Logo TecNM.png" alt="logotec">
</div>
<div class="Main">
<?php 
include "sidebar.php";
?>
<div class="menu margen">
<div class="header-table">
        <h2>Gestión de usuarios</h2>
    </div>

    <table class="tabla-eventos" id="tablaEventos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre usuario</th>
                <th>Rol</th>
                <th>Correo</th>
                <th>Matricula</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user['id_user']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['Nombre']; ?></td>
                    <td><?php echo $user['correo']; ?></td>
                    <td><?php echo $user['matricula']; ?></td>
                    <td class="acciones">
                        <a class="btn-edit" href="edit_user.php?id=<?php echo $user['id_user']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn-delete" href="#"
                        onclick="confirmarBorrado(event, 'delete_user.php?id=<?php echo $user['id_user']; ?>')"><i class="fa-solid fa-trash"></i>
                    </a>
                    </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
</div>
<?php if (isset($_GET['status'])): ?>
<script>
    const status = "<?php echo $_GET['status']; ?>";
    
    if (status === "success") {
        Swal.fire({
            icon: 'success',
            title: '¡Logrado!',
            text: 'El rol se actualizó correctamente.',
            timer: 2000,
            showConfirmButton: false,
        });
    } else if (status === "deleted") {
        Swal.fire({
            icon: 'success',
            title: 'Eliminado',
            text: 'El usuario ha sido borrado.',
            confirmButtonColor: '#002b70'
        });
    } else if (status === "succes_edit") {
        Swal.fire({
            icon: 'success',
            title: '¡Se ha modificado el evento!',
            text: 'El evento se modifico con exito',
            confirmButtonColor: '#002b70'
        });
    } else if (status === "error_db") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema con la base de datos.',
        });
    }

     window.history.replaceState({}, document.title, window.location.pathname)

</script>
<?php endif; ?>
</body>
<script>
    function confirmarBorrado(event, url) {
    event.preventDefault(); // Detiene el enlace para que no recargue la página

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#002b70', // El azul de tu logo
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borrarlo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url; // Redirige solo si confirmó
        }
    })
}
</script>
<script>
$(document).ready(function() {
    $('#tablaEventos').DataTable({
        // 'B' activa los botones, 'f' el buscador, 'r' el procesamiento, 
        // 't' la tabla, 'i' la info y 'p' la paginación.
        "dom": '<"top-table"Bf>rtip', 
        "buttons": [
            {
                extend: 'pdfHtml5',
                text: '<i class="fa-solid fa-file-pdf"></i> Generar Reporte',
                className: 'btn-exportar-pdf', // Clase para tu CSS
                title: 'Listado de usuarios en el sistema',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5] // EXCLUIMOS la columna 6 (Acciones/Botones)
                },
                customize: function (doc) {
                    // Esto centra la tabla en el PDF generado
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ],
        "lengthChange": false,
        "pageLength": 5,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        "columnDefs": [
            { "orderable": false, "targets": 5 }
        ]
    });
});

</script>   
</html>
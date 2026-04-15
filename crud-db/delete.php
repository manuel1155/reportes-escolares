<?php
include './../lib/db.php';

$id = $_GET['id'];
$success = false;

if (isset($id)) {
    $sql = "DELETE FROM personas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminando... | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .loader-content {
            text-align: center;
            color: #6c757d;
        }
        .spinner-border {
            color: #dc3545; /* Rojo para indicar eliminación/peligro */
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body>

    <div class="loader-content">
        <?php if ($success): ?>
            <script>
                Swal.fire({
                    title: 'Registro Eliminado',
                    text: 'El dato ha sido borrado del sistema correctamente.',
                    icon: 'success',
                    confirmButtonColor: '#1B5E20', // Verde CBTa para confirmar cierre
                    confirmButtonText: 'Regresar'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php else: ?>
            <script>
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo eliminar el registro solicitado.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="spinner-border" role="status">
            <span class="visually-hidden">Procesando...</span>
        </div>
        <p class="mt-3">Actualizando base de datos institucional...</p>
    </div>

</body>
</html>
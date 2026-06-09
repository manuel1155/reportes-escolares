<?php
include './../lib/db.php';

$success = false;
$error = false;
$errorMsg = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Intentamos la eliminación
        $stmt = $conn->prepare("DELETE FROM alumnos WHERE id = ?");
        $stmt->execute([$id]);
        $success = true;
    } catch (PDOException $e) {
        // Si el alumno tiene registros vinculados (reportes, etc), fallará la integridad
        $error = true;
        $errorMsg = "No se puede eliminar el alumno porque tiene registros asociados (reportes o asistencias).";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminando Alumno | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
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

        .delete-loader {
            text-align: center;
            background: white;
            padding: 3rem;
            border-radius: 35px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }

        .spinner-del {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(220, 53, 69, 0.1);
            border-left-color: #dc3545;
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .text-del {
            margin-top: 1.5rem;
            color: #666;
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="delete-loader animate__animated animate__fadeIn">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Alumno Eliminado',
                        text: 'El registro ha sido removido del sistema permanentemente.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Continuar'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 700);
            </script>
        <?php endif; ?>

        <?php if ($error): ?>
            <script>
                Swal.fire({
                    title: 'Acción no permitida',
                    text: '<?= $errorMsg ?>',
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Entendido'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="spinner-del"></div>
        <div class="text-del">Procesando baja definitiva...</div>
    </div>

</body>
</html>
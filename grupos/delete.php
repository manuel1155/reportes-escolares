<?php
include './../lib/db.php';

$id = $_GET['id'] ?? null;
$success = false;

if ($id) {
    // Borrado lógico para conservar integridad referencial
    $sql = "UPDATE grupos SET activo = 0 WHERE id = :id";
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
    <title>Eliminando Grupo | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --danger-soft: #dc3545;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .loader-container {
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Spinner sutil y moderno */
        .spinner-minimal {
            width: 3.5rem;
            height: 3.5rem;
            border: 3px solid rgba(220, 53, 69, 0.1);
            border-top: 3px solid var(--danger-soft);
            border-radius: 50%;
            display: inline-block;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-text {
            color: #6c757d;
            font-weight: 600;
            margin-top: 1.2rem;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <div class="loader-container">
        <?php if ($success): ?>
            <script>
                // Retraso breve para suavizar la transición
                setTimeout(() => {
                    Swal.fire({
                        title: 'Grupo Removido',
                        text: 'El grupo ha sido dado de baja del listado activo.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Entendido',
                        showClass: { popup: 'animate__animated animate__zoomIn' },
                        hideClass: { popup: 'animate__animated animate__fadeOut' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1000);
            </script>
        <?php else: ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo procesar la baja del grupo.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1000);
            </script>
        <?php endif; ?>

        <div class="spinner-minimal" role="status"></div>
        <p class="loading-text">Actualizando base de datos...</p>
    </div>

</body>
</html>

<?php
include './../lib/db.php';

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    $sql = "UPDATE carreras SET nombre = :nombre WHERE id = :id";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([':nombre' => $nombre, ':id' => $id])) {
        $success = true;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizando... | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
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

        .loader-content {
            text-align: center;
            animation: fadeIn;
            animation-duration: 0.8s;
        }

        /* Spinner Dorado para indicar "Edición" */
        .update-spinner {
            width: 4rem;
            height: 4rem;
            border: 0.4em solid rgba(184, 134, 11, 0.1);
            border-left-color: var(--cbta-gold);
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .status-text {
            color: #555;
            font-weight: 600;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>

    <div class="loader-content">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: '¡Cambios Guardados!',
                        text: 'La carrera se ha actualizado correctamente.',
                        icon: 'success',
                        iconColor: '#B8860B',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Volver al listado',
                        showClass: { popup: 'animate__animated animate__fadeInUp' },
                        hideClass: { popup: 'animate__animated animate__fadeOutDown' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 800);
            </script>
        <?php elseif ($error || $_SERVER["REQUEST_METHOD"] != "POST"): ?>
            <script>
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudieron guardar los cambios.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="update-spinner" role="status"></div>
        <h5 class="status-text">Sincronizando cambios...</h5>
        <p class="text-muted small">CBTa 159 • Panel Administrativo</p>
    </div>

</body>
</html>
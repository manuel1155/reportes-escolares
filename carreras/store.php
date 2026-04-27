<?php
include './../lib/db.php';

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO carreras (nombre, activo) VALUES (:nombre, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);

    if ($stmt->execute()) {
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
    <title>Guardando Carrera... | CBTa 159</title>
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
            animation-duration: 1s;
        }

        /* Spinner con los colores del CBTa */
        .cbta-spinner {
            width: 4rem;
            height: 4rem;
            border: 0.4em solid rgba(27, 94, 32, 0.1);
            border-left-color: var(--cbta-gold);
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .status-text {
            color: var(--cbta-green);
            font-weight: 600;
            margin-top: 1.5rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <div class="loader-content">
        <?php if ($success): ?>
            <script>
                // Pequeña pausa para que se vea la animación institucional
                setTimeout(() => {
                    Swal.fire({
                        title: '¡Carrera Registrada!',
                        text: 'La nueva oferta académica se guardó correctamente.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Continuar',
                        showClass: { popup: 'animate__animated animate__backInDown' },
                        hideClass: { popup: 'animate__animated animate__fadeOutDown' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1000);
            </script>
        <?php endif; ?>

        <?php if ($error): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Error de Registro',
                        text: 'No se pudo guardar la carrera. Intente de nuevo.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1000);
            </script>
        <?php endif; ?>

        <div class="cbta-spinner" role="status"></div>
        <h5 class="status-text">Procesando información académica...</h5>
        <p class="text-muted small">CBTa 159 • Sistema de Gestión de Carreras</p>
    </div>

</body>
</html>
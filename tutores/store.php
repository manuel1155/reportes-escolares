<?php
include './../lib/db.php';

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];

    // Insertamos incluyendo el campo activo por defecto en 1
    $sql = "INSERT INTO tutores (nombre, primer_apellido, segundo_apellido, activo) 
            VALUES (:nombre, :primer_apellido, :segundo_apellido, 1)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':primer_apellido', $primer_apellido);
    $stmt->bindParam(':segundo_apellido', $segundo_apellido);

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
    <title>Procesando... | CBTa 159</title>
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

        .cbta-spinner {
            width: 4rem;
            height: 4rem;
            border: 0.4em solid rgba(27, 94, 32, 0.1);
            border-left-color: var(--cbta-green);
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
                // Pequeña pausa para asegurar la experiencia visual
                setTimeout(() => {
                    Swal.fire({
                        title: '¡Tutor Registrado!',
                        text: 'La información se ha guardado exitosamente en el sistema.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Finalizar',
                        showClass: { popup: 'animate__animated animate__zoomIn' },
                        hideClass: { popup: 'animate__animated animate__zoomOut' }
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
                        title: 'Error de Sistema',
                        text: 'No se pudo completar el registro del tutor.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1000);
            </script>
        <?php endif; ?>

        <div class="cbta-spinner" role="status"></div>
        <h5 class="status-text">Guardando información de tutoría...</h5>
        <p class="text-muted small">CBTa 159 • Control Administrativo</p>
    </div>

</body>
</html>
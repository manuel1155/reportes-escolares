<?php
include './../lib/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $carnet = $_POST['carnet'];

    $sql = "UPDATE personas SET nombre = :nombre, apellidos = :apellidos, carnet = :carnet WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':carnet', $carnet);

    if ($stmt->execute()) {
        echo "Registro actualizado exitosamente";
    } else {
        echo "Error al actualizar el registro";
    }

    header("Location: index.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --danger-red: #dc3545;
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
            /* Aplicamos la animación de entrada suave */
            animation: fadeInUp; 
            animation-duration: 0.8s;
        }

        /* Spinner personalizado con gradiente sutil */
        .custom-spinner {
            width: 4rem;
            height: 4rem;
            border: 0.4em solid rgba(220, 53, 69, 0.1);
            border-left-color: var(--danger-red);
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .status-text {
            color: #6c757d;
            font-weight: 500;
            letter-spacing: 0.5px;
            /* Animación de pulso para el texto */
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 1; }
            100% { opacity: 0.6; }
        }

        /* Decoración de fondo minimalista */
        .bg-decoration {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.03;
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
        }
    </style>
</head>
<body>

    <div class="bg-decoration"></div>

    <div class="loader-content">
        <?php if ($success): ?>
            <script>
                // Retrasamos un poco el SweetAlert para que se aprecie la animación de carga
                setTimeout(() => {
                    Swal.fire({
                        title: 'Registro Eliminado',
                        text: 'El dato ha sido borrado del sistema correctamente.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Regresar',
                        showClass: { popup: 'animate__animated animate__zoomIn' },
                        hideClass: { popup: 'animate__animated animate__fadeOut' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1500);
            </script>
        <?php else: ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo eliminar el registro solicitado.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1500);
            </script>
        <?php endif; ?>

        <div class="custom-spinner mb-4" role="status"></div>
        
        <h5 class="status-text">Procesando solicitud...</h5>
        <p class="text-muted small">Actualizando base de datos del CBTa 159</p>
    </div>

</body>
</html>
<?php
include './../lib/db.php';

$id = $_GET['id'] ?? null;
$success = false;

if ($id) {
    // Aplicamos tu lógica de borrado lógico
    $sql = "UPDATE tutores SET activo = 0 WHERE id = :id";
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
    <title>Desactivando Tutor | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
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
            animation: fadeInUp; 
            animation-duration: 0.8s;
        }

        /* Spinner Rojo para indicar eliminación/baja */
        .delete-spinner {
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
            font-weight: 600;
            margin-top: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }
    </style>
</head>
<body>

    <div class="loader-content">
        <?php if ($success): ?>
            <script>
                // Pequeño retraso para que el usuario perciba la animación de "trabajando"
                setTimeout(() => {
                    Swal.fire({
                        title: 'Tutor Desactivado',
                        text: 'El registro ha sido dado de baja del sistema.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Regresar',
                        showClass: { popup: 'animate__animated animate__zoomIn' },
                        hideClass: { popup: 'animate__animated animate__fadeOutDown' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1200);
            </script>
        <?php else: ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo completar la desactivación.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1200);
            </script>
        <?php endif; ?>

        <div class="delete-spinner" role="status"></div>
        <h5 class="status-text">Procesando baja del tutor...</h5>
        <p class="text-muted small">CBTa 159 • Sistema Institucional</p>
    </div>

</body>
</html>
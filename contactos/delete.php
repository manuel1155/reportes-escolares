<?php
include './../lib/db.php';

$id = $_GET['id'] ?? null;
$success = false;

if ($id) {
    // Aplicamos borrado lógico (activo = 0) para mantener historial si es necesario
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
    <title>Eliminando Contacto | CBTa 159</title>
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

        .delete-container {
            text-align: center;
            animation: fadeIn 0.5s;
        }

        .spinner-del {
            width: 3.5rem;
            height: 3.5rem;
            border: 3px solid rgba(220, 53, 69, 0.1);
            border-top: 3px solid #dc3545;
            border-radius: 50%;
            display: inline-block;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .status-text {
            color: #6c757d;
            font-weight: 600;
            margin-top: 1rem;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <div class="delete-container">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Contacto Removido',
                        text: 'La información del tutor ha sido dada de baja correctamente.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Entendido',
                        showClass: { popup: 'animate__animated animate__zoomIn' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 800);
            </script>
        <?php else: ?>
            <script>
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo procesar la baja del contacto.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="spinner-del" role="status"></div>
        <p class="status-text">Actualizando directorio...</p>
    </div>

</body>
</html>
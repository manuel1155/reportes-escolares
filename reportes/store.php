<?php
include './../lib/db.php';

$success = false;
$error = false;

// Verificamos el método de envío
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = true;
    $msg = "Acceso no permitido";
} elseif (empty($_POST['descripcion'])) {
    $error = true;
    $msg = "Debe seleccionar una causa válida";
} else {
    // Procesamos la inserción
    try {
        $stmt = $conn->prepare("INSERT INTO causas_reporte (descripcion, puntos_penalizacion) VALUES (?, ?)");
        if ($stmt->execute([
            $_POST['descripcion'],
            $_POST['puntos_penalizacion']
        ])) {
            $success = true;
        } else {
            $error = true;
            $msg = "No se pudo registrar la causa";
        }
    } catch (Exception $e) {
        $error = true;
        $msg = "Error en la base de datos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando Catálogo | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .store-loader {
            text-align: center;
            background: white;
            padding: 3rem;
            border-radius: 35px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        }

        .spinner-custom {
            width: 55px;
            height: 55px;
            border: 4px solid rgba(27, 94, 32, 0.1);
            border-left-color: #1B5E20;
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-text {
            margin-top: 1.5rem;
            color: #1B5E20;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
    </style>
</head>
<body>

    <div class="store-loader animate__animated animate__zoomIn">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Catálogo Actualizado',
                        text: 'La nueva causa se ha integrado correctamente al sistema.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Finalizar',
                        showClass: { popup: 'animate__animated animate__fadeInDown' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 800);
            </script>
        <?php endif; ?>

        <?php if ($error): ?>
            <script>
                Swal.fire({
                    title: 'Error de Registro',
                    text: '<?= $msg ?? "Ocurrió un problema inesperado." ?>',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="spinner-custom"></div>
        <div class="loading-text">Guardando nueva infracción...</div>
    </div>

</body>
</html>
<?php
include './../lib/db.php';

$success = false;
$error = false;
$msg = "";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = true;
    $msg = "Acceso no permitido";
} elseif (
    empty($_POST['alumno_id']) ||
    empty($_POST['nombre_tutor']) ||
    empty($_POST['telefono_tutor'])
) {
    $error = true;
    $msg = "Faltan datos obligatorios para el registro";
} else {
    try {
        $sql = "INSERT INTO contactos 
                (alumno_id, nombre_tutor, telefono_tutor, parentesco, activo)
                VALUES (?, ?, ?, ?, 1)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $_POST['alumno_id'],
            $_POST['nombre_tutor'],
            $_POST['telefono_tutor'],
            $_POST['parentesco'] ?? null
        ]);

        $success = true;
    } catch (PDOException $e) {
        $error = true;
        $msg = "Error en la base de datos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando Contacto | CBTa 159</title>
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

        .loader-box {
            text-align: center;
            background: white;
            padding: 3.5rem;
            border-radius: 35px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        }

        .spinner-contact {
            width: 55px;
            height: 55px;
            border: 4px solid rgba(27, 94, 32, 0.1);
            border-left-color: #1B5E20;
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .status-msg {
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

    <div class="loader-box animate__animated animate__zoomIn">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Contacto Guardado',
                        text: 'El tutor ha sido vinculado al alumno exitosamente.',
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
                    title: 'No se pudo registrar',
                    text: '<?= $msg ?>',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.history.back(); // Regresa al formulario para corregir
                });
            </script>
        <?php endif; ?>

        <div class="spinner-contact"></div>
        <div class="status-msg">Vinculando tutor...</div>
    </div>

</body>
</html>
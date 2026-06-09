<?php
include './../lib/db.php';

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "UPDATE contactos SET 
                alumno_id = ?, 
                nombre_tutor = ?, 
                telefono_tutor = ?, 
                parentesco = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            $_POST['alumno_id'],
            $_POST['nombre_tutor'],
            $_POST['telefono_tutor'],
            $_POST['parentesco'],
            $_POST['id']
        ]);

        if ($result) {
            $success = true;
        } else {
            $error = true;
        }
    } catch (PDOException $e) {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizando Directorio | CBTa 159</title>
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

        .update-box {
            text-align: center;
            background: white;
            padding: 3rem;
            border-radius: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            border-bottom: 6px solid #B8860B; /* Acento Dorado */
        }

        .spinner-sync {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(184, 134, 11, 0.1);
            border-top-color: #B8860B;
            border-radius: 50%;
            display: inline-block;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .sync-text {
            margin-top: 1.5rem;
            color: #555;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <div class="update-box animate__animated animate__fadeIn">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Contacto Actualizado',
                        text: 'La información del tutor se ha sincronizado correctamente.',
                        icon: 'success',
                        iconColor: '#B8860B',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Regresar',
                        showClass: { popup: 'animate__animated animate__zoomIn' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 700);
            </script>
        <?php endif; ?>

        <?php if ($error): ?>
            <script>
                Swal.fire({
                    title: 'Error al actualizar',
                    text: 'No se pudieron guardar los cambios en el contacto.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="spinner-sync"></div>
        <div class="sync-text">Sincronizando datos de contacto...</div>
    </div>

</body>
</html>
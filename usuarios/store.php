<?php
include './../lib/db.php';

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Insertamos asegurando que el campo 'activo' sea 1 por defecto
    $sql = "INSERT INTO usuarios (nombre, username, password, rol, activo) 
            VALUES (:nombre, :username, :password, :rol, 1)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':rol', $rol);

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
    <title>Procesando Usuario | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
        }

        body {
            background-color: #f4f7f6;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .loader-container {
            text-align: center;
            background: white;
            padding: 3.5rem;
            border-radius: 35px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        }

        /* Spinner de seguridad sutil */
        .secure-loader {
            width: 55px;
            height: 55px;
            border: 4px solid rgba(27, 94, 32, 0.1);
            border-left-color: var(--cbta-green);
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .status-text {
            margin-top: 1.5rem;
            color: var(--cbta-green);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
    </style>
</head>
<body>

    <div class="loader-container animate__animated animate__zoomIn">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Usuario Registrado',
                        text: 'Las credenciales han sido creadas y el acceso está activo.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Finalizar',
                        showClass: { popup: 'animate__animated animate__fadeInDown' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1000);
            </script>
        <?php endif; ?>

        <?php if ($error): ?>
            <script>
                Swal.fire({
                    title: 'Error de Sistema',
                    text: 'No se pudo completar el registro del usuario.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="secure-loader"></div>
        <div class="status-text">Cifrando credenciales...</div>
    </div>

</body>
</html>
<?php
include './../lib/db.php';

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $alumnos       = isset($_POST['alumnos']) ? 1 : 0;
    $carreras      = isset($_POST['carreras']) ? 1 : 0;
    $causa         = isset($_POST['causa']) ? 1 : 0;
    $contactos     = isset($_POST['contactos']) ? 1 : 0;
    $grupos        = isset($_POST['grupos']) ? 1 : 0;
    $inscripciones = isset($_POST['inscripciones']) ? 1 : 0;
    $personas      = isset($_POST['personas']) ? 1 : 0;
    $reportes      = isset($_POST['reportes']) ? 1 : 0;
    $tutores       = isset($_POST['tutores']) ? 1 : 0;
    $usuarios       = isset($_POST['usuarios']) ? 1 : 0;

    $sql = "UPDATE usuarios
            SET email = :email,
                password = :password,
                alumnos = :alumnos,
                carreras = :carreras,
                causa = :causa,
                contactos = :contactos,
                grupos = :grupos,
                inscripciones = :inscripciones,
                personas = :personas,
                reportes = :reportes,
                tutores = :tutores,
                usuarios = :usuarios
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    $stmt->bindParam(':alumnos', $alumnos);
    $stmt->bindParam(':carreras', $carreras);
    $stmt->bindParam(':causa', $causa);
    $stmt->bindParam(':contactos', $contactos);
    $stmt->bindParam(':grupos', $grupos);
    $stmt->bindParam(':inscripciones', $inscripciones);
    $stmt->bindParam(':personas', $personas);
    $stmt->bindParam(':reportes', $reportes);
    $stmt->bindParam(':tutores', $tutores);
    $stmt->bindParam(':usuarios', $usuarios);


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
    <title>Actualizando Usuario | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-gold: #B8860B;
            --cbta-green: #1B5E20;
        }

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
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-bottom: 5px solid var(--cbta-gold);
        }

        .spinner-gold {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(184, 134, 11, 0.1);
            border-top: 4px solid var(--cbta-gold);
            border-radius: 50%;
            display: inline-block;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .status-msg {
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
                        title: 'Perfil Actualizado',
                        text: 'Los datos del usuario se han sincronizado correctamente.',
                        icon: 'success',
                        iconColor: '#B8860B',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Regresar',
                        showClass: { popup: 'animate__animated animate__zoomIn' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 800);
            </script>
        <?php endif; ?>

        <?php if ($error): ?>
            <script>
                Swal.fire({
                    title: 'Error de Actualización',
                    text: 'No se pudo guardar la información del usuario.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="spinner-gold"></div>
        <div class="status-msg">Aplicando cambios en el sistema...</div>
    </div>

</body>
</html>
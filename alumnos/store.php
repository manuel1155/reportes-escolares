<?php
include './../lib/db.php';

$success = false;
$error = false;
$msg = "";

try {
    // Validar campos obligatorios sin romper la estética con die()
    if (empty($_POST['matricula']) || empty($_POST['nombre']) || empty($_POST['apellido_paterno'])) {
        $error = true;
        $msg = "Faltan campos obligatorios para el registro.";
    } else {
        // Manejo de grupo_id opcional
        $grupo_id = !empty($_POST['grupo_id']) ? $_POST['grupo_id'] : null;

        $sql = "INSERT INTO alumnos 
                (matricula, nombre, apellido_paterno, apellido_materno, grupo_id, activo)
                VALUES (?, ?, ?, ?, ?, 1)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $_POST['matricula'],
            $_POST['nombre'],
            $_POST['apellido_paterno'],
            $_POST['apellido_materno'],
            $grupo_id // Corregido: antes decía $grupos
        ]);

        $success = true;
    }
} catch (PDOException $e) {
    $error = true;
    // Captura de error de duplicado (ej. misma matrícula)
    if ($e->getCode() == 23000) {
        $msg = "La matrícula ya se encuentra registrada en el sistema.";
    } else {
        $msg = "Error interno: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando Registro | CBTa 159</title>
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

        .loader-card {
            text-align: center;
            background: white;
            padding: 3.5rem;
            border-radius: 35px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            border-top: 5px solid #1B5E20;
        }

        .spinner-custom {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(27, 94, 32, 0.1);
            border-top-color: #1B5E20;
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .loading-text {
            margin-top: 1.5rem;
            color: #1B5E20;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

    <div class="loader-card animate__animated animate__zoomIn">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: '¡Registro Exitoso!',
                        text: 'El alumno ha sido dado de alta en el sistema correctamente.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Ir al Listado',
                        showClass: { popup: 'animate__animated animate__fadeInUp' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 800);
            </script>
        <?php endif; ?>

        <?php if ($error): ?>
            <script>
                Swal.fire({
                    title: 'Hubo un inconveniente',
                    text: '<?= $msg ?>',
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Corregir Datos'
                }).then(() => {
                    window.history.back();
                });
            </script>
        <?php endif; ?>

        <div class="spinner-custom"></div>
        <div class="loading-text">Sincronizando Expediente...</div>
    </div>

</body>
</html>
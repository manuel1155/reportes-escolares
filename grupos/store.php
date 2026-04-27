<?php
include './../lib/db.php';

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grado = $_POST['grado'];
    $grupo = $_POST['grupo'];
    $periodo = $_POST['periodo'];
    $id_carrera = $_POST['id_carrera'];
    $id_tutor = $_POST['id_tutor'];

    // Insertamos incluyendo el campo activo por defecto en 1
    $sql = "INSERT INTO grupos (grado, grupo, periodo, id_carrera, id_tutor, activo) 
            VALUES (:grado, :grupo, :periodo, :id_carrera, :id_tutor, 1)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':grado', $grado);
    $stmt->bindParam(':grupo', $grupo);
    $stmt->bindParam(':periodo', $periodo);
    $stmt->bindParam(':id_carrera', $id_carrera);
    $stmt->bindParam(':id_tutor', $id_tutor);

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
    <title>Procesando Grupo | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
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

        .loader-box {
            text-align: center;
            background: white;
            padding: 3rem;
            border-radius: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }

        /* Spinner Institucional de doble color */
        .cbta-loader {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(27, 94, 32, 0.1);
            border-top: 5px solid var(--cbta-green);
            border-bottom: 5px solid var(--cbta-gold);
            border-radius: 50%;
            display: inline-block;
            animation: spin 1.2s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .status-msg {
            margin-top: 1.5rem;
            color: var(--cbta-green);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="loader-box animate__animated animate__fadeIn">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: '¡Grupo Configurado!',
                        text: 'El grupo ha sido registrado exitosamente en el ciclo escolar.',
                        icon: 'success',
                        iconColor: '#1B5E20',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Continuar',
                        showClass: { popup: 'animate__animated animate__backInDown' },
                        hideClass: { popup: 'animate__animated animate__backOutDown' }
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                }, 1200);
            </script>
        <?php endif; ?>

        <?php if ($error): ?>
            <script>
                Swal.fire({
                    title: 'Error de Registro',
                    text: 'Hubo un problema al intentar crear el grupo.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="cbta-loader"></div>
        <div class="status-msg">Vinculando datos académicos...</div>
        <p class="text-muted small mt-2">CBTa 159 • Sistema de Gestión</p>
    </div>

</body>
</html>
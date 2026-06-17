<?php
include './../lib/db.php';

$success = false;
$error = false;
$msg = "";

try {
    // Validar campos obligatorios de forma silenciosa
    if (empty($_POST['id']) || empty($_POST['curp']) || empty($_POST['nombre']) || empty($_POST['primer_apellido'])) {
        $error = true;
        $msg = "Faltan datos obligatorios para actualizar el expediente.";
    } else {
    

        // Ejecutar actualización
        $sql = "UPDATE alumnos SET 
                curp = ?, 
                nombre = ?, 
                primer_apellido = ?, 
                segundo_apellido = ?,
                f_modificado = NOW() WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $_POST['curp'],
            $_POST['nombre'],
            $_POST['primer_apellido'],
            $_POST['segundo_apellido'],
            $_POST['id']
        ]);

        $success = true;
    } 
 } catch (PDOException $e) {
    $error = true;
    if ($e->getCode() == 23000) {
        $msg = "La curp ingresada ya pertenece a otro alumno.";
   } else {

    $msg = $e->getMessage();
   }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizando Expediente | CBTa 159</title>
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

        .sync-card {
            text-align: center;
            background: white;
            padding: 3rem;
            border-radius: 35px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            border-bottom: 6px solid #B8860B;
        }

        .spinner-sync {
            width: 55px;
            height: 55px;
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

    <div class="sync-card animate__animated animate__fadeIn">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Expediente Actualizado',
                        text: 'Los cambios se han sincronizado correctamente en la base de datos escolar.',
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
                    title: 'Error de Actualización',
                    text: '<?= $msg ?>',
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Reintentar'
                }).then(() => {
                    window.history.back();
                });
            </script>
        <?php endif; ?>

        <div class="spinner-sync"></div>
        <div class="sync-text">Sincronizando cambios en el historial...</div>
    </div>

</body>
</html>
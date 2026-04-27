<?php
include './../lib/db.php';

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $grado = $_POST['grado'];
    $grupo = $_POST['grupo'];
    $periodo = $_POST['periodo'];
    $id_carrera = $_POST['id_carrera'];
    $id_tutor = $_POST['id_tutor'];

    // Corrección de la consulta y vinculación de parámetros
    $sql = "UPDATE grupos SET 
            grado = :grado, 
            grupo = :grupo, 
            periodo = :periodo, 
            id_carrera = :id_carrera, 
            id_tutor = :id_tutor 
            WHERE id = :id";
            
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);
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
    <title>Actualizando... | CBTa 159</title>
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
            background-color: #f8f9fa;
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
            padding: 3rem;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-bottom: 5px solid var(--cbta-gold);
        }

        .spinner-update {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(184, 134, 11, 0.1);
            border-left-color: var(--cbta-gold);
            border-radius: 50%;
            display: inline-block;
            animation: rotate 1s infinite linear;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .text-update {
            margin-top: 1.5rem;
            color: #555;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <div class="loader-card animate__animated animate__fadeIn">
        <?php if ($success): ?>
            <script>
                setTimeout(() => {
                    Swal.fire({
                        title: 'Cambios Guardados',
                        text: 'La configuración del grupo ha sido actualizada correctamente.',
                        icon: 'success',
                        iconColor: '#B8860B',
                        confirmButtonColor: '#1B5E20',
                        confirmButtonText: 'Regresar al listado',
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
                    title: 'Error de Actualización',
                    text: 'No se pudieron sincronizar los cambios con la base de datos.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        <?php endif; ?>

        <div class="spinner-update"></div>
        <div class="text-update">Sincronizando información del grupo...</div>
    </div>

</body>
</html>
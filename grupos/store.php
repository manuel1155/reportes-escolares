<?php
include './../lib/db.php';

$success = false;
$error = false;
$exists = false; // Variable para detectar duplicados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grado = $_POST['grado'];
    $grupo = $_POST['grupo'];
    $periodo = $_POST['periodo'];
    $id_carrera = $_POST['id_carrera'];
    $id_tutor = $_POST['id_tutor'];

    // 1. VALIDACIÓN: Verificar si ya existe un grupo con los mismos datos
    $checkSql = "SELECT COUNT(*) FROM grupos WHERE grado = :grado AND grupo = :grupo AND periodo = :periodo AND id_carrera = :id_carrera AND activo = 1";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([
        ':grado' => $grado,
        ':grupo' => $grupo,
        ':periodo' => $periodo,
        ':id_carrera' => $id_carrera
    ]);

    if ($checkStmt->fetchColumn() > 0) {
        $exists = true; // El grupo ya existe
    } else {
        // 2. REGISTRO: Si no existe, procedemos a insertar

        $sql = "INSERT INTO grupos (grado, grupo, periodo, id_carrera, id_tutor,f_registro, activo) 
                VALUES (:grado, :grupo, :periodo, :id_carrera, :id_tutor, NOW(), 1)";
        
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
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando... | CBTa 159</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body { background-color: #f4f7f6; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; font-family: 'Inter', sans-serif; }
        .loader { width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #1B5E20; border-radius: 50%; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

    <div class="text-center">
        <div class="loader mb-3 mx-auto"></div>
        <p class="text-muted">Verificando información...</p>
    </div>

    <script>
        // CASO 1: EL GRUPO YA EXISTE (Animación de Advertencia)
        <?php if ($exists): ?>
            Swal.fire({
                title: 'Registro Duplicado',
                text: 'El grupo ya existe en este periodo, no se puede registrar nuevamente.',
                icon: 'warning',
                iconColor: '#B8860B',
                confirmButtonColor: '#1B5E20',
                confirmButtonText: 'Entendido',
                showClass: { popup: 'animate__animated animate__shakeX' } // Animación de error sutil
            }).then(() => {
                window.location.href = 'create.php'; // Regresa al formulario para corregir
            });

        // CASO 2: ÉXITO
        <?php elseif ($success): ?>
            Swal.fire({
                title: '¡Registrado!',
                text: 'El grupo se ha creado exitosamente.',
                icon: 'success',
                confirmButtonColor: '#1B5E20',
                showClass: { popup: 'animate__animated animate__fadeInDown' }
            }).then(() => {
                window.location.href = 'index.php';
            });

        // CASO 3: ERROR DE SQL
        <?php elseif ($error): ?>
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al guardar en la base de datos.',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            }).then(() => {
                window.location.href = 'index.php';
            });
        <?php endif; ?>
    </script>
</body>
</html>
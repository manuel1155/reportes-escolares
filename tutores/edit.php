<?php
include './../lib/db.php';

$id = $_GET['id'] ?? null;
$stmt = $conn->prepare("SELECT * FROM tutores WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute(); 
$tutor = $stmt->fetch();

// Redirigir si el tutor no existe
if (!$tutor) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Editar Tutor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --bg-light: #F4F7F6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .form-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            border-top: 8px solid var(--cbta-gold); /* Dorado para Edición */
        }

        .icon-header {
            width: 70px;
            height: 70px;
            background: rgba(184, 134, 11, 0.1);
            color: var(--cbta-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--cbta-green);
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-text {
            background-color: #fff;
            color: var(--cbta-gold);
            border-right: none;
        }

        .form-control {
            border-left: none;
            padding: 12px;
            border-radius: 0 10px 10px 0 !important;
            background-color: #fff;
        }

        .btn-update {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 1rem;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .btn-update:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.2);
            color: white;
        }

        .btn-cancel {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #999;
            font-size: 0.9rem;
            margin-top: 1.5rem;
            font-weight: 500;
        }

        .btn-cancel:hover { color: #dc3545; }
    </style>
</head>
<body>

<div class="form-card animate__animated animate__zoomIn">
    <div class="icon-header">
        <i class="fas fa-user-edit"></i>
    </div>
    
    <h1>Editar Tutor</h1>

    <form id="editTutorForm" action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $tutor['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre(s)</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($tutor['nombre']); ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Primer Apellido</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                <input type="text" class="form-control" name="primer_apellido" value="<?php echo htmlspecialchars($tutor['primer_apellido']); ?>" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Segundo Apellido</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                <input type="text" class="form-control" name="segundo_apellido" value="<?php echo htmlspecialchars($tutor['segundo_apellido']); ?>" required>
            </div>
        </div>

        <button type="button" id="btnActualizar" class="btn btn-update">
            <i class="fas fa-save me-2"></i> Guardar Cambios
        </button>

        <a href="./index.php" class="btn-cancel">
            <i class="fas fa-times me-1"></i> Cancelar edición
        </a>
    </form>
</div>

<script>
document.getElementById('btnActualizar').addEventListener('click', function() {
    Swal.fire({
        title: '¿Confirmar cambios?',
        text: "Se actualizará la información del tutor en el sistema",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1B5E20',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Revisar',
        showClass: { popup: 'animate__animated animate__fadeInDown' },
        hideClass: { popup: 'animate__animated animate__fadeOutUp' }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editTutorForm').submit();
        }
    });
});
</script>

</body>
</html>
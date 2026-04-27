<?php
include './../lib/db.php';

$id = $_GET['id'] ?? null;
$stmt = $conn->prepare("SELECT * FROM carreras WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$carreras = $stmt->fetch();

// Si no existe la carrera, redirigir al index
if (!$carreras) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Editar Carrera</title>
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
        }

        .form-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            padding: 3rem;
            width: 100%;
            max-width: 480px;
            border-top: 6px solid var(--cbta-gold); /* Dorado para diferenciar edición de creación */
            position: relative;
        }

        .icon-badge {
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
            color: var(--cbta-green);
            font-weight: 700;
            text-align: center;
            font-size: 1.6rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: var(--cbta-gold);
        }

        .form-control {
            border-left: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
            background-color: #fffdf9;
        }

        .btn-update {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
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
            color: #888;
            font-size: 0.9rem;
            margin-top: 1.5rem;
            transition: 0.3s;
        }

        .btn-cancel:hover {
            color: var(--danger-red);
        }
    </style>
</head>
<body>

<div class="form-card animate__animated animate__zoomIn">
    <div class="icon-badge">
        <i class="fas fa-edit"></i>
    </div>
    
    <h1>Modificar Carrera</h1>

    <form id="editForm" action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $carreras['id']; ?>">

        <div class="mb-4">
            <label class="form-label">Nombre de la carrera</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                <input type="text" class="form-control" name="nombre" 
                       value="<?php echo htmlspecialchars($carreras['nombre']); ?>" required>
            </div>
        </div>

        <button type="button" id="submitBtn" class="btn btn-update">
            <i class="fas fa-sync-alt me-2"></i> Actualizar Datos
        </button>

        <a href="index.php" class="btn-cancel">
            <i class="fas fa-chevron-left me-1"></i> Cancelar y volver
        </a>
    </form>
</div>

<script>
document.getElementById('submitBtn').addEventListener('click', function() {
    Swal.fire({
        title: '¿Guardar cambios?',
        text: "Se actualizará la información de la carrera",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1B5E20', // Verde CBTa
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Revisar',
        showClass: { popup: 'animate__animated animate__fadeInDown' },
        hideClass: { popup: 'animate__animated animate__fadeOutUp' }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editForm').submit();
        }
    });
});
</script>

</body>
</html>
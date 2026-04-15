<?php
include './../lib/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM personas WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$persona = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Edición de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --cbta-green: #1B5E20; /* Verde institucional */
            --cbta-gold: #B8860B;  /* Dorado institucional equilibrado */
            --bg-light: #F4F7F6;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: #333;
        }

        .card-institutional {
            background: #ffffff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
            border-top: 6px solid var(--cbta-green); /* Acento institucional superior */
        }

        .header-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--cbta-green);
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 0.4rem;
        }

        .form-control {
            background: #fdfdfd;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 12px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--cbta-green);
            box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.1);
            outline: none;
        }

        .btn-update {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-update:hover {
            background-color: #144618;
            box-shadow: 0 4px 12px rgba(27, 94, 32, 0.2);
            color: white;
        }

        .btn-cancel {
            background-color: transparent;
            color: #777;
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: 0.3s;
        }

        .btn-cancel:hover {
            background-color: #fff1f1;
            border-color: #f8d7da;
            color: #dc3545;
        }

        /* Ajuste para iconos */
        .input-group-text {
            background: transparent;
            border-right: none;
            color: var(--cbta-green);
        }
        .form-control-with-icon {
            border-left: none;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card-institutional">
        <div class="header-logo">
            <i class="fas fa-graduation-cap fa-3x" style="color: var(--cbta-gold);"></i>
        </div>
        
        <h1>Edición de Estudiante</h1>

        <form action="update.php" method="post" id="editForm">
            <input type="hidden" name="id" value="<?php echo $persona['id']; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre(s)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control form-control-with-icon" id="nombre" name="nombre" value="<?php echo $persona['nombre']; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                    <input type="text" class="form-control form-control-with-icon" id="apellidos" name="apellidos" value="<?php echo $persona['apellidos']; ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="carnet" class="form-label">Carnet de Identidad / Matrícula</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    <input type="text" class="form-control form-control-with-icon" id="carnet" name="carnet" value="<?php echo $persona['carnet']; ?>" required>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="button" onclick="confirmarEdicion()" class="btn btn-update">
                    Actualizar Registro
                </button>
                <a href="./index.php" class="btn btn-cancel">
                    cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function confirmarEdicion() {
    Swal.fire({
        title: '¿Confirmar actualización?',
        text: "Los datos del estudiante serán modificados en el sistema.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#1B5E20', // Verde CBTa
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Guardar cambios',
        cancelButtonText: 'Revisar',
        borderRadius: '15px'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editForm').submit();
        }
    })
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
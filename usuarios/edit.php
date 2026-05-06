<?php
include './../lib/db.php';

if (!isset($_GET['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$id_usuario = $_GET['id_usuario'];
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute(); 
$usuario = $stmt->fetch();

if (!$usuario) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --bg-soft: #f4f7f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-soft);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .edit-card {
            background: #ffffff;
            border-radius: 30px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.06);
            padding: 3.5rem 2.5rem;
            width: 100%;
            max-width: 550px;
            border-top: 8px solid var(--cbta-gold);
            position: relative;
        }

        .header-icon {
            width: 65px;
            height: 65px;
            background: rgba(184, 134, 11, 0.1);
            color: var(--cbta-gold);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1.5rem;
        }

        h1 {
            font-weight: 800;
            color: var(--cbta-green);
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 2rem;
            text-transform: uppercase;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .input-group-text {
            background: transparent;
            border-right: none;
            color: var(--cbta-gold);
        }

        .form-control, .form-select {
            border-left: none;
            padding: 12px;
            background-color: #fcfcfc;
            font-size: 0.95rem;
            border-radius: 0 12px 12px 0 !important;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
            background-color: #fff;
        }

        /* Botones Sutiles */
        .btn-update {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 15px;
            font-weight: 700;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            margin-top: 1rem;
        }

        .btn-update:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(27, 94, 32, 0.2);
        }

        .btn-cancel {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #999;
            font-weight: 600;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .btn-cancel:hover { color: #dc3545; }
    </style>
</head>
<body>

<div class="edit-card animate__animated animate__fadeIn">
    <div class="header-icon">
        <i class="fas fa-user-gear"></i>
    </div>
    
    <h1>Modificar Usuario</h1>

    <form id="editForm" action="update.php" method="post">
        <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario']; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-signature"></i></span>
                <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($usuario['nombre']); ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($usuario['username']); ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password (Hash)</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
                <input type="text" class="form-control" name="password" value="<?= htmlspecialchars($usuario['password']); ?>" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Rol Asignado</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                <select name="rol" class="form-select" required>
                    <?php
                    $roles = ["prefectura", "administrador", "maestro"];
                    foreach ($roles as $r): ?>
                        <option value="<?= $r ?>" <?= ($usuario['rol'] == $r) ? 'selected' : '' ?>>
                            <?= ucfirst($r) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="button" onclick="confirmarCambios()" class="btn-update">
            <i class="fas fa-sync-alt me-2"></i>Actualizar Datos
        </button>

        <a href="./index.php" class="btn-cancel">
            <i class="fas fa-arrow-left me-1"></i> Descartar cambios
        </a>
    </form>
</div>

<script>
function confirmarCambios() {
    Swal.fire({
        title: '¿Confirmar edición?',
        text: "Se actualizarán los permisos del usuario.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1B5E20',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editForm').submit();
        }
    });
}
</script>

</body>
</html>
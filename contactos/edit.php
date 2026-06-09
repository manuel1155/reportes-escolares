<?php
include './../lib/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM contactos WHERE id = ?");
$stmt->execute([$id]);
$contacto = $stmt->fetch();

if (!$contacto) {
    header("Location: index.php");
    exit();
}

$alumnos = $conn->query("SELECT id, nombre FROM alumnos WHERE activo = 1 ORDER BY nombre ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Editar Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --soft-bg: #f4f7f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-bg);
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
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 550px;
            border-top: 8px solid var(--cbta-gold);
        }

        .header-icon {
            width: 65px;
            height: 65px;
            background: rgba(184, 134, 11, 0.1);
            color: var(--cbta-gold);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1.5rem;
        }

        h2 {
            font-weight: 800;
            color: #333;
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
            display: block;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: var(--cbta-gold);
            border-radius: 12px 0 0 12px;
        }

        .form-control, .form-select {
            border-left: none;
            border-radius: 0 12px 12px 0;
            padding: 12px;
            background-color: #fcfcfc;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
            background-color: #fff;
        }

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
        }

        .btn-cancel:hover { color: #dc3545; }
    </style>
</head>
<body>

<div class="edit-card animate__animated animate__fadeIn">
    <div class="header-icon">
        <i class="fas fa-user-pen"></i>
    </div>
    
    <h2>Editar Contacto</h2>

    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $contacto['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Alumno vinculado</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                <select name="alumno_id" class="form-select" required>
                    <?php foreach($alumnos as $a): ?>
                        <option value="<?= $a['id'] ?>" <?= ($contacto['alumno_id'] == $a['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre del Tutor</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                <input type="text" name="nombre_tutor" value="<?= htmlspecialchars($contacto['nombre_tutor']) ?>" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    <input type="text" name="telefono_tutor" value="<?= htmlspecialchars($contacto['telefono_tutor']) ?>" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Parentesco</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                    <input type="text" name="parentesco" value="<?= htmlspecialchars($contacto['parentesco']) ?>" class="form-control">
                </div>
            </div>
        </div>

        <button type="submit" class="btn-update">
            <i class="fas fa-sync-alt me-2"></i>Actualizar Información
        </button>

        <a href="index.php" class="btn-cancel">
            <i class="fas fa-arrow-left me-1"></i> Descartar cambios
        </a>
    </form>
</div>

</body>
</html>
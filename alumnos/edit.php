<?php
include './../lib/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM alumnos WHERE id = ?");
$stmt->execute([$id]);
$alumno = $stmt->fetch();

if (!$alumno) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Editar Expediente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
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
            padding: 30px 20px;
        }

        .edit-card {
            background: #ffffff;
            border-radius: 35px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.06);
            padding: 3.5rem;
            width: 100%;
            max-width: 700px;
            border-top: 10px solid var(--cbta-gold);
            position: relative;
        }

        .header-box {
            text-align: center;
            margin-bottom: 3rem;
        }

        .icon-edit {
            width: 80px;
            height: 80px;
            background: rgba(184, 134, 11, 0.1);
            color: var(--cbta-gold);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            transform: rotate(-10deg);
        }

        h2 {
            font-weight: 800;
            color: #333;
            font-size: 1.6rem;
            text-transform: uppercase;
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 800;
            color: #bbb;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-label::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--cbta-green);
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border-radius: 15px;
            padding: 14px 18px;
            border: 2px solid #f0f0f0;
            background-color: #fcfcfc;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--cbta-gold);
            background-color: #fff;
            box-shadow: none;
        }

        .btn-update {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 18px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            width: 100%;
        }

        .btn-update:hover {
            background-color: #144618;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(27, 94, 32, 0.2);
        }

        .btn-back {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #adb5bd;
            font-weight: 600;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .btn-back:hover { color: #dc3545; }
    </style>
</head>
<body>

<div class="edit-card animate__animated animate__fadeInUp">
    <div class="header-box">
        <div class="icon-edit">
            <i class="fas fa-user-pen"></i>
        </div>
        <h2>Editar Alumno</h2>
        <p class="text-muted small">Actualización de datos generales del expediente.</p>
    </div>

    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $alumno['id'] ?>">

        <div class="section-label">Clave de Registro</div>
        
        <div class="mb-4">
            <label class="form-label">Matrícula</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-hashtag"></i></span>
                <input type="text" name="matricula" value="<?= htmlspecialchars($alumno['matricula']) ?>" class="form-control" style="border-left: none;" required>
            </div>
        </div>

        <div class="section-label">Información Personal</div>

        <div class="mb-3">
            <label class="form-label">Nombre(s)</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($alumno['nombre']) ?>" class="form-control" required>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <label class="form-label">Apellido Paterno</label>
                <input type="text" name="apellido_paterno" value="<?= htmlspecialchars($alumno['apellido_paterno']) ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Apellido Materno</label>
                <input type="text" name="apellido_materno" value="<?= htmlspecialchars($alumno['apellido_materno']) ?>" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn-update">
            <i class="fas fa-sync-alt me-2"></i>Guardar Cambios
        </button>

        <a href="index.php" class="btn-back">
            <i class="fas fa-times me-1"></i> Cancelar edición
        </a>
    </form>
</div>

</body>
</html>
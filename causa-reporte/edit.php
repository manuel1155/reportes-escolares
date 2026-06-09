<?php
include './../lib/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM causas_reporte WHERE id = ?");
$stmt->execute([$id]);
$c = $stmt->fetch();

if (!$c) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Editar Causa de Reporte</title>
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
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            border-top: 8px solid var(--cbta-gold);
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(184, 134, 11, 0.1);
            color: var(--cbta-gold);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1.5rem;
        }

        h2 {
            font-weight: 800;
            color: var(--cbta-green);
            font-size: 1.4rem;
            text-align: center;
            margin-bottom: 2rem;
            text-transform: uppercase;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
            border: 2px solid #eee;
            font-size: 0.95rem;
            transition: 0.3s;
            background-color: #fcfcfc;
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
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 1rem;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-update:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.2);
        }

        .btn-cancel {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #adb5bd;
            font-weight: 600;
            margin-top: 1.2rem;
            font-size: 0.85rem;
        }

        .btn-cancel:hover {
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="edit-card animate__animated animate__fadeInUp">
    <div class="header-icon">
        <i class="fas fa-pen-to-square"></i>
    </div>
    
    <h2>Editar Causa</h2>

    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $c['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Descripción de la Causa</label>
            <input type="text" name="descripcion" value="<?= htmlspecialchars($c['descripcion']) ?>" class="form-control" placeholder="Ej. Llegar tarde" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Puntos de Penalización</label>
            <input type="number" name="puntos_penalizacion" value="<?= $c['puntos_penalizacion'] ?>" class="form-control" min="1" max="100" required>
        </div>

        <button type="submit" class="btn btn-update">
            <i class="fas fa-sync-alt me-2"></i>Actualizar Causa
        </button>
        
        <a href="index.php" class="btn-cancel">
            <i class="fas fa-times me-1"></i> Cancelar edición
        </a>
    </form>
</div>

</body>
</html>
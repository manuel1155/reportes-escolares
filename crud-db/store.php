<?php
include './../lib/db.php';

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $carnet = $_POST['carnet'];

    $sql = "INSERT INTO personas (nombre, apellidos, carnet) VALUES (:nombre, :apellidos, :carnet)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':carnet', $carnet);

    if ($stmt->execute()) {
        // Redirección con éxito
        header("Location: index.php?status=success");
        exit();
    } else {
        header("Location: index.php?status=error");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Nuevo Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            max-width: 500px;
            position: relative;
        }

        .form-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--cbta-green);
            border-radius: 20px 20px 0 0;
        }

        h2 {
            color: var(--cbta-green);
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        p.subtitle {
            color: #888;
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: var(--cbta-green);
        }

        .form-control {
            border-left: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
            background-color: #fcfdfc;
        }

        .btn-save {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: 700;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s;
        }

        .btn-save:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.2);
            color: white;
        }

        .btn-back {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #aaa;
            font-size: 0.9rem;
            margin-top: 1.5rem;
            transition: 0.3s;
        }

        .btn-back:hover {
            color: var(--cbta-gold);
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            background: rgba(27, 94, 32, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--cbta-green);
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

<div class="form-card">
    <div class="icon-circle">
        <i class="fas fa-user-plus"></i>
    </div>
    <h2>Nuevo Registro</h2>
    <p class="subtitle">Complete los datos para dar de alta en el sistema institucional.</p>

    <form action="" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre(s)</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Juan Antonio" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ej: Pérez García" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="carnet" class="form-label">Carnet de Identidad</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                <input type="text" class="form-control" id="carnet" name="carnet" placeholder="Número de carnet o matrícula" required>
            </div>
        </div>

        <button type="submit" class="btn btn-save">
            <i class="fas fa-check-circle me-2"></i> Registrar Persona
        </button>

        <a href="index.php" class="btn-back">
            <i class="fas fa-chevron-left me-1"></i> Cancelar y volver
        </a>
    </form>
</div>

</body>
</html>
<?php
include './../lib/db.php';

$stmt = $conn->prepare("SELECT * FROM carreras WHERE activo = 1");
$stmt->execute();
$carreras = $stmt->fetchAll();

$stmt = $conn->prepare("SELECT * FROM tutores WHERE activo = 1");
$stmt->execute();
$tutores = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Añadir Grupo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --soft-bg: #F8F9FA;
            --input-focus: rgba(27, 94, 32, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-bg);
            background-image: radial-gradient(#d1d1d1 0.8px, transparent 0.8px);
            background-size: 30px 30px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .form-card {
            background: #ffffff;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            padding: 3rem;
            width: 100%;
            max-width: 700px;
            border-top: 8px solid var(--cbta-green);
        }

        .header-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .header-section i {
            font-size: 2.5rem;
            color: var(--cbta-green);
            background: var(--input-focus);
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            margin: 0 auto 1rem;
        }

        h1 {
            font-weight: 800;
            color: var(--cbta-green);
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: var(--cbta-gold);
        }

        .form-select, .form-control {
            border-left: none;
            padding: 12px;
            background-color: #fcfcfc;
            border-radius: 0 12px 12px 0 !important;
        }

        .form-select:focus, .form-control:focus {
            box-shadow: 0 0 0 4px var(--input-focus);
            border-color: var(--cbta-green);
        }

        /* --- BOTONES SUTILES --- */
        .actions-container {
            display: flex;
            gap: 15px;
            margin-top: 2.5rem;
        }

        .btn-save {
            flex: 2;
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(27, 94, 32, 0.2);
        }

        .btn-cancel {
            flex: 1;
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: none;
            padding: 15px;
            border-radius: 15px;
            font-weight: 700;
            text-decoration: none;
            text-align: center;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel:hover {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<div class="form-card animate__animated animate__fadeIn">
    <div class="header-section">
        <i class="fas fa-layer-group"></i>
        <h1>Configurar Grupo</h1>
        <p class="text-muted small">Complete los campos para registrar un nuevo grupo académico.</p>
    </div>

    <form action="store.php" method="post">
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label">Grado Académico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-signal"></i></span>
                    <select name="grado" class="form-select" required>
                        <option value="">Seleccionar...</option>
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?>° Semestre</option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">Letra de Grupo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-font"></i></span>
                    <select name="grupo" class="form-select" required>
                        <option value="">Seleccionar...</option>
                        <?php foreach (['A','B','C','D','E','F'] as $letra): ?>
                            <option value="<?= $letra ?>">Grupo <?= $letra ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <label class="form-label">Periodo Escolar</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
                    <select name="periodo" class="form-select" required>
                        <option value="">Selecciona el ciclo...</option>
                        <?php
                        $periodos = ["Febrero-2026","Agosto-2026","Febrero-2027","Agosto-2027"];
                        foreach ($periodos as $p): ?>
                            <option value="<?= $p ?>"><?= $p ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <label class="form-label">Carrera Técnica</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <select name="id_carrera" class="form-select" required>
                        <option value="">Asignar carrera...</option>
                        <?php foreach ($carreras as $row): ?>
                            <option value="<?= $row['id'] ?>">
                                <?= htmlspecialchars($row['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <label class="form-label">Tutor Asignado</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                    <select name="id_tutor" class="form-select" required>
                        <option value="">Asignar docente...</option>
                        <?php foreach ($tutores as $row): ?>
                            <option value="<?= $row['id'] ?>">
                                <?= htmlspecialchars($row['nombre'] . " " . $row['primer_apellido']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="actions-container">
            <button type="submit" class="btn-save">
                <i class="fas fa-plus-circle me-2"></i>Guardar Grupo
            </button>
            <a href="index.php" class="btn-cancel">
                Cancelar
            </a>
        </div>
    </form>
</div>

</body>
</html>
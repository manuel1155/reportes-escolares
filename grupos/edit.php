<?php
include './../lib/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Obtener el grupo a editar
$stmt = $conn->prepare("SELECT * FROM grupos WHERE id = ?");
$stmt->execute([$id]);
$grupo = $stmt->fetch();

if (!$grupo) {
    header("Location: index.php");
    exit();
}

// Carreras y Tutores para los selects
$carreras = $conn->query("SELECT * FROM carreras WHERE activo = 1")->fetchAll();
$tutores = $conn->query("SELECT * FROM tutores WHERE activo = 1")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Editar Grupo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --bg-light: #f4f7f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .edit-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 650px;
            padding: 3rem;
            border-top: 8px solid var(--cbta-gold); /* Dorado por ser Edición */
            position: relative;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: rgba(184, 134, 11, 0.1);
            color: var(--cbta-gold);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1.5rem;
        }

        h1 {
            font-weight: 800;
            color: var(--cbta-green);
            text-align: center;
            font-size: 1.6rem;
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
            background: #fdfdfd;
            border-right: none;
            color: var(--cbta-gold);
        }

        .form-select {
            border-left: none;
            background-color: #fdfdfd;
            padding: 11px;
            font-size: 0.95rem;
            border-radius: 0 10px 10px 0 !important;
        }

        .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        /* Botones Sutiles */
        .btn-update {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-update:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(27, 94, 32, 0.2);
        }

        .btn-cancel {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #aaa;
            font-weight: 600;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .btn-cancel:hover { color: #dc3545; }
    </style>
</head>
<body>

<div class="edit-card animate__animated animate__zoomIn">
    <div class="icon-box">
        <i class="fas fa-pen-to-square"></i>
    </div>
    <h1>Editar Grupo</h1>

    <form id="updateForm" action="update.php" method="post">
        <input type="hidden" name="id" value="<?= $grupo['id'] ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Grado</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-signal"></i></span>
                    <select name="grado" class="form-select" required>
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <option value="<?= $i ?>" <?= ($grupo['grado'] == $i) ? 'selected' : '' ?>>
                                <?= $i ?>° Semestre
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Grupo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-font"></i></span>
                    <select name="grupo" class="form-select" required>
                        <?php foreach (['A','B','C','D','E','F'] as $letra): ?>
                            <option value="<?= $letra ?>" <?= ($grupo['grupo'] == $letra) ? 'selected' : '' ?>>
                                Grupo <?= $letra ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Periodo Escolar</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    <select name="periodo" class="form-select" required>
                        <?php
                        $periodos = ["Febrero-2026","Agosto-2026","Febrero-2027","Agosto-2027","Febrero-2028","Agosto-2028"];
                        foreach ($periodos as $p): ?>
                            <option value="<?= $p ?>" <?= ($grupo['periodo'] == $p) ? 'selected' : '' ?>>
                                <?= $p ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Carrera Técnica</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                    <select name="id_carrera" class="form-select" required>
                        <?php foreach ($carreras as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($grupo['id_carrera'] == $row['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-12 mb-4">
                <label class="form-label">Tutor del Grupo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                    <select name="id_tutor" class="form-select" required>
                        <?php foreach ($tutores as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($grupo['id_tutor'] == $row['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nombre'] . " " . $row['primer_apellido']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <button type="button" onclick="confirmUpdate()" class="btn-update">
            <i class="fas fa-sync-alt me-2"></i>Actualizar Grupo
        </button>

        <a href="index.php" class="btn-cancel">
            <i class="fas fa-times me-1"></i> Descartar cambios
        </a>
    </form>
</div>

<script>
function confirmUpdate() {
    Swal.fire({
        title: '¿Guardar cambios?',
        text: "La información del grupo será actualizada.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1B5E20',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Revisar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('updateForm').submit();
        }
    });
}
</script>

</body>
</html>
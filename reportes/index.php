<?php
include './../lib/db.php';
// Solo traemos las causas que podrían estar activas o todas las del catálogo
$stmt = $conn->query("SELECT * FROM causas_reporte ORDER BY puntos_penalizacion DESC");
$causas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Catálogo de Causas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            padding: 40px 20px;
        }

        .main-card {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            border-top: 8px solid var(--cbta-green);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h2 {
            font-weight: 800;
            color: var(--cbta-green);
            font-size: 1.3rem;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .btn-add {
            background-color: var(--cbta-green);
            color: white;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .btn-add:hover {
            background-color: #144618;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.2);
        }

        /* Estilo de Tabla Sutil */
        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table thead th {
            border: none;
            color: #999;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px;
        }

        .table tbody tr {
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            border-radius: 12px;
            transition: 0.2s;
        }

        .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border: none;
            font-size: 0.9rem;
        }

        .table tbody tr:hover {
            background-color: #fcfcfc;
            transform: scale(1.005);
        }

        /* Badge de Puntos */
        .puntos-badge {
            background: #fff5f5;
            color: #dc3545;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 0.8rem;
            border: 1px solid #ffebeb;
        }

        /* Botones de Acción Sutiles */
        .action-link {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.2s;
            margin-left: 5px;
        }

        .link-edit { background: rgba(184, 134, 11, 0.1); color: var(--cbta-gold); }
        .link-edit:hover { background: var(--cbta-gold); color: white; }

        .link-delete { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .link-delete:hover { background: #dc3545; color: white; }

        .btn-back {
            color: #adb5bd;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-back:hover { color: var(--cbta-gold); }
    </style>
</head>
<body>

<div class="main-card animate__animated animate__fadeIn">
    <div class="header-section">
        <h2><i class="fas fa-clipboard-list me-2"></i>Catálogo de Causas</h2>
        <a href="create.php" class="btn-add">
            <i class="fas fa-plus me-1"></i> Nueva Causa
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th width="55%">Descripción de la Falta</th>
                    <th width="15%" class="text-center">Penalización</th>
                    <th width="20%" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($causas as $c): ?>
                <tr>
                    <td class="text-muted fw-bold">#<?= $c['id'] ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($c['descripcion']) ?></td>
                    <td class="text-center">
                        <span class="puntos-badge">
                            -<?= $c['puntos_penalizacion'] ?> pts
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="edit.php?id=<?= $c['id'] ?>" class="action-link link-edit" title="Editar">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="#" onclick="confirmarEliminar(<?= $c['id'] ?>)" class="action-link link-delete" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 pt-3 border-top">
        <a href="../" class="btn-back">
            <i class="fas fa-arrow-left me-1"></i> Panel de Control
        </a>
    </div>
</div>

<script>
function confirmarEliminar(id) {
    Swal.fire({
        title: '¿Eliminar causa?',
        text: "Esta acción no se puede deshacer y afectará al catálogo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `delete.php?id=${id}`;
        }
    })
}
</script>

</body>
</html>
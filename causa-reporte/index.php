<?php
include './../lib/db.php';
// Aseguramos que la consulta traiga las causas activas y las ordene de manera consistente
$stmt = $conn->query("SELECT * FROM causas WHERE activo = 1 ORDER BY id ASC");
$causas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Catálogo de Causas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
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
            padding: 35px 15px;
            margin: 0;
        }

        .main-card {
            max-width: 1000px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 30px;
            box-shadow: 0 15px 45px rgba(0,0,0,0.04);
            border-top: 8px solid var(--cbta-green);
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        h2 {
            font-weight: 800;
            color: var(--cbta-green);
            font-size: 1.4rem;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .btn-new {
            background-color: var(--cbta-green);
            color: #ffffff;
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 700;
            font-size: 0.85rem;
            text-decoration: none;
            transition: 0.3s;
            box-shadow: 0 4px 12px rgba(27, 94, 32, 0.15);
        }

        .btn-new:hover {
            background-color: #144618;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(27, 94, 32, 0.25);
        }

        /* Estilo Armónico de Tabla Flotante */
        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
            margin-top: -10px;
        }

        .table thead th {
            border: none;
            color: #9ca3af;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 5px 20px;
        }

        .table tbody tr {
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.015);
            border-radius: 14px;
            transition: 0.2s;
        }

        .table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            border: none;
            font-size: 0.95rem;
            color: #374151;
        }

        /* Redondeado de esquinas internas por fila */
        .table tbody tr td:first-child { border-radius: 14px 0 0 14px; }
        .table tbody tr td:last-child { border-radius: 0 14px 14px 0; }

        .table tbody tr:hover {
            transform: scale(1.01);
            background-color: #fdfdfd;
            box-shadow: 0 6px 16px rgba(0,0,0,0.03);
        }

        .id-badge {
            font-weight: 700;
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .causa-texto {
            font-weight: 600;
            color: #1f2937;
        }

        /* Botones de acción minimalistas */
        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.2s;
            margin-left: 4px;
        }

        .btn-edit { 
            background: rgba(184, 134, 11, 0.08); 
            color: var(--cbta-gold); 
        }
        .btn-edit:hover { 
            background: var(--cbta-gold); 
            color: #ffffff; 
        }

        .btn-del { 
            background: rgba(220, 53, 69, 0.08); 
            color: #dc3545; 
        }
        .btn-del:hover { 
            background: #dc3545; 
            color: #ffffff; 
        }

        .btn-back {
            color: #9ca3af;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-back:hover { 
            color: var(--cbta-gold); 
        }
    </style>
</head>
<body>

<div class="main-card animate__animated animate__fadeIn">
    <div class="header-flex">
        <h2><i class="fas fa-gavel me-2"></i>Causas de Reporte</h2>
        <a href="create.php" class="btn-new">
            <i class="fas fa-plus me-1"></i> Nueva Causa
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th width="75%">Descripción del Criterio / Falta</th>
                    <th width="15%" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($causas as $c): ?>
                <tr>
                    <td><span class="id-badge">#<?= $c['id'] ?></span></td>
                    <td>
                        <span class="causa-texto"><?= htmlspecialchars($c['descripcion']) ?></span>
                    </td>
                    <td class="text-center">
                        <a href="edit.php?id=<?= $c['id'] ?>" class="action-btn btn-edit" title="Editar Normativa">
                            <i class="fas fa-pen-to-square"></i>
                        </a>
                        <a href="#" onclick="confirmarEliminar(<?= $c['id'] ?>)" class="action-btn btn-del" title="Eliminar Causa">
                            <i class="fas fa-trash-can"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 pt-3 border-top">
        <a href="../" class="btn-back">
            <i class="fas fa-chevron-left me-1"></i> Regresar al Menú principal
        </a>
    </div>
</div>

<script>
function confirmarEliminar(id) {
    Swal.fire({
        title: '¿Eliminar causa de reporte?',
        text: "Esta acción inhabilitará este criterio para futuros reportes.",
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
<?php
include './../lib/db.php';

// Mejoramos la consulta para traer solo los activos y ordenar alfabéticamente por alumno
$sql = "SELECT contactos.*, alumnos.nombre AS alumno_nombre 
        FROM contactos
        LEFT JOIN alumnos ON contactos.alumno_id = alumnos.id
        WHERE contactos.activo = 1
        ORDER BY alumnos.nombre ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$contactos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Directorio de Contactos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            padding: 30px 15px;
        }

        .main-card {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            border-top: 8px solid var(--cbta-green);
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
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
            color: white;
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.85rem;
        }

        .btn-new:hover {
            background-color: #144618;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.2);
        }

        /* Estilo de Tabla "Directorio" */
        .table {
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .table thead th {
            border: none;
            color: #999;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 20px;
        }

        .table tbody tr {
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            border-radius: 15px;
            transition: 0.2s;
        }

        .table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            border: none;
            font-size: 0.95rem;
        }

        .table tbody tr:hover {
            transform: scale(1.01);
            background-color: #fcfcfc;
        }

        /* Avatar sutil para el alumno */
        .alumno-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alumno-icon {
            width: 35px;
            height: 35px;
            background: rgba(27, 94, 32, 0.08);
            color: var(--cbta-green);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .phone-badge {
            background: #f1f8e9;
            color: var(--cbta-green);
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            text-decoration: none;
            transition: 0.2s;
            margin-left: 5px;
        }

        .btn-edit { background: rgba(184, 134, 11, 0.1); color: var(--cbta-gold); }
        .btn-edit:hover { background: var(--cbta-gold); color: white; }

        .btn-del { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .btn-del:hover { background: #dc3545; color: white; }

        .btn-back {
            color: #adb5bd;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-back:hover { color: var(--cbta-green); }
    </style>
</head>
<body>

<div class="main-card animate__animated animate__fadeIn">
    <div class="header-flex">
        <h2><i class="fas fa-address-book me-2"></i>Directorio de Contactos</h2>
        <a href="create.php" class="btn-new">
            <i class="fas fa-plus me-2"></i>Nuevo Contacto
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="30%">Alumno</th>
                    <th width="25%">Nombre del Tutor</th>
                    <th width="15%">Teléfono</th>
                    <th width="15%">Parentesco</th>
                    <th width="10%" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($contactos as $c): ?>
                <tr>
                    <td class="text-muted fw-bold">#<?= $c['id'] ?></td>
                    <td>
                        <div class="alumno-info">
                            <div class="alumno-icon"><i class="fas fa-user-graduate"></i></div>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars($c['alumno_nombre']) ?></span>
                        </div>
                    </td>
                    <td class="text-secondary"><?= htmlspecialchars($c['nombre_tutor']) ?></td>
                    <td>
                        <span class="phone-badge">
                            <i class="fas fa-phone-alt me-1" style="font-size: 0.7rem;"></i>
                            <?= htmlspecialchars($c['telefono_tutor']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-light text-secondary border fw-normal p-2" style="border-radius: 6px;">
                            <?= htmlspecialchars($c['parentesco'] ?: 'No definido') ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="edit.php?id=<?= $c['id'] ?>" class="action-btn btn-edit" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" onclick="confirmarBaja(<?= $c['id'] ?>)" class="action-btn btn-del" title="Eliminar">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 pt-3 border-top">
        <a href="../" class="btn-back">
            <i class="fas fa-chevron-left me-1"></i> Regresar al Inicio
        </a>
    </div>
</div>

<script>
function confirmarBaja(id) {
    Swal.fire({
        title: '¿Eliminar contacto?',
        text: "La información del tutor será desactivada del directorio.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        showClass: { popup: 'animate__animated animate__headShake' }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `delete.php?id=${id}`;
        }
    })
}
</script>

</body>
</html>
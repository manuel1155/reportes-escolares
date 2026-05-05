<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Gestión de Tutores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --bg-light: #f4f7f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            padding: 40px 20px;
        }

        .main-container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            border-top: 8px solid var(--cbta-green);
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            font-weight: 800;
            color: var(--cbta-green);
            margin: 0;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
        }

        .btn-add {
            background-color: var(--cbta-green);
            color: white;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(27, 94, 32, 0.2);
        }

        .btn-add:hover {
            background-color: #144618;
            color: white;
            transform: translateY(-2px);
        }

        .table {
            margin-top: 10px;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table thead th {
            border: none;
            color: #888;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            padding: 15px;
        }

        .table tbody tr {
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border-radius: 10px;
            transition: transform 0.2s;
        }

        .table tbody tr:hover {
            transform: scale(1.01);
            background-color: #fcfdfc;
        }

        .table tbody td {
            padding: 18px 15px;
            border-top: 1px solid #f8f9fa;
            border-bottom: 1px solid #f8f9fa;
            vertical-align: middle;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-edit { background: rgba(184, 134, 11, 0.1); color: var(--cbta-gold); }
        .btn-edit:hover { background: var(--cbta-gold); color: white; }

        .btn-delete { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .btn-delete:hover { background: #dc3545; color: white; }

        .badge-status {
            background: rgba(27, 94, 32, 0.1);
            color: var(--cbta-green);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 800;
        }

        .btn-back {
            color: #aaa;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-back:hover { color: var(--cbta-gold); }
    </style>
</head>
<body>

<div class="main-container animate__animated animate__fadeIn">
    <div class="header-flex">
        <h1><i class="fas fa-users-rectangle"></i> Gestión de Tutores</h1>
        <a href="create.php" class="btn-add">
            <i class="fas fa-user-plus me-2"></i>Registrar Tutor
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="8%">ID</th>
                    <th width="20%">Nombre</th>
                    <th width="20%">1er Apellido</th>
                    <th width="20%">2do Apellido</th>
                    <th width="12%">Estado</th>
                    <th width="20%" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include './../lib/db.php';

                try {
                    $stmt = $conn->prepare("SELECT * FROM tutores WHERE activo = 1");
                    $stmt->execute();
                    $result = $stmt->fetchAll();

                    foreach($result as $row) {
                        echo "<tr>
                                <td class='fw-bold text-muted'>#".$row['id']."</td>
                                <td class='fw-semibold'>".htmlspecialchars($row['nombre'])."</td>
                                <td>".htmlspecialchars($row['primer_apellido'])."</td>
                                <td>".htmlspecialchars($row['segundo_apellido'])."</td>
                                <td><span class='badge-status'>ACTIVO</span></td>
                                <td class='text-center'>
                                    <a href='edit.php?id=".$row['id']."' class='btn-action btn-edit me-2' title='Editar'>
                                        <i class='fas fa-user-pen'></i>
                                    </a>
                                    <button type='button' class='btn-action btn-delete btn-confirm-delete' data-id='".$row['id']."' title='Eliminar'>
                                        <i class='fas fa-trash-can'></i>
                                    </button>
                                </td>
                              </tr>";
                    }
                } catch(PDOException $e) {
                    echo "<tr><td colspan='6' class='text-center text-danger'>Error al conectar con la base de datos</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 pt-3 border-top">
        <a href="./.." class="btn-back">
            <i class="fas fa-chevron-left me-1"></i> Regresar al Inicio
        </a>
    </div>
</div>

<script>
// Manejo de eliminación Premium con SweetAlert2
document.querySelectorAll('.btn-confirm-delete').forEach(button => {
    button.addEventListener('click', function() {
        const tutorId = this.getAttribute('data-id');

        Swal.fire({
            title: '¿Eliminar tutor?',
            text: "Esta acción marcará al tutor como inactivo en el sistema institucional.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1B5E20',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            showClass: { popup: 'animate__animated animate__fadeInDown' },
            hideClass: { popup: 'animate__animated animate__fadeOutUp' }
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigir al proceso de eliminación
                window.location.href = `delete.php?id=${tutorId}`;
            }
        });
    });
});
</script>

</body>
</html>
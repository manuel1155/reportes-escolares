<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Gestión de Carreras</title>
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

        .main-container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-left: 5px solid var(--cbta-gold);
            padding-left: 15px;
        }

        h1 {
            font-weight: 800;
            color: var(--cbta-green);
            margin: 0;
            text-transform: uppercase;
            font-size: 1.5rem;
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .table thead {
            background-color: #fcfcfc;
        }

        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            color: #888;
            padding: 15px;
            border-bottom: 2px solid #eee;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #444;
        }

        .btn-add {
            background-color: var(--cbta-green);
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-add:hover {
            background-color: #144618;
            color: white;
            transform: translateY(-2px);
        }

        .btn-action {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: 0.3s;
            border: none;
            text-decoration: none;
        }

        .btn-edit { background: rgba(27, 94, 32, 0.1); color: var(--cbta-green); margin-right: 5px; }
        .btn-edit:hover { background: var(--cbta-green); color: white; }

        .btn-delete { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .btn-delete:hover { background: #dc3545; color: white; }

        .badge-active {
            background-color: rgba(27, 94, 32, 0.1);
            color: var(--cbta-green);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
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
        <h1>Gestión de Carreras</h1>
        <a href="create.php" class="btn-add">
            <i class="fas fa-plus me-2"></i>Nueva Carrera
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th width="50%">Nombre de la Carrera</th>
                    <th width="20%">Estado</th>
                    <th width="20%" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include './../lib/db.php';
                $stmt = $conn->prepare("SELECT * FROM carreras WHERE activo = 1");
                $stmt->execute();
                $result = $stmt->fetchAll();

                foreach($result as $row) {
                    echo "<tr>
                            <td class='fw-bold text-muted'>#".$row['id']."</td>
                            <td class='fw-semibold'>".$row['nombre']."</td>
                            <td><span class='badge-active'>Activo</span></td>
                            <td class='text-center'>
                                <a href='edit.php?id=".$row['id']."' class='btn-action btn-edit' title='Editar'>
                                    <i class='fas fa-pen'></i>
                                </a>
                                <button type='button' class='btn-action btn-delete btn-delete-confirm' data-id='".$row['id']."' title='Eliminar'>
                                    <i class='fas fa-trash'></i>
                                </button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="./.." class="btn-back">
            <i class="fas fa-arrow-left me-1"></i> Regresar al Inicio
        </a>
    </div>
</div>

<script>
// Lógica de SweetAlert2 para la eliminación
document.querySelectorAll('.btn-delete-confirm').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');

        Swal.fire({
            title: '¿Eliminar carrera?',
            text: "El registro se marcará como inactivo",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1B5E20',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            showClass: { popup: 'animate__animated animate__fadeInDown' },
            hideClass: { popup: 'animate__animated animate__fadeOutUp' }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `delete.php?id=${id}`;
            }
        });
    });
});
</script>

</body>
</html>
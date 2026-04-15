<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Gestión de Personas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: #333;
            padding-top: 2rem;
        }

        .main-container {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .header-title {
            color: var(--cbta-green);
            font-weight: 700;
            border-left: 5px solid var(--cbta-gold);
            padding-left: 15px;
            margin-bottom: 2rem;
        }

        /* Tabla Estilizada */
        .table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table thead th {
            background-color: transparent;
            border: none;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            background-color: #ffffff;
            transition: transform 0.2s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        .table tbody tr:hover {
            background-color: #f1f8f1 !important;
            transform: scale(1.005);
        }

        .table td {
            vertical-align: middle;
            padding: 15px;
            border: none;
            border-top: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
        }

        .table td:first-child { border-left: 1px solid #f0f0f0; border-radius: 10px 0 0 10px; }
        .table td:last-child { border-right: 1px solid #f0f0f0; border-radius: 0 10px 10px 0; }

        /* Botones */
        .btn-add {
            background-color: var(--cbta-green);
            color: white;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: 0.3s;
        }

        .btn-add:hover {
            background-color: #144618;
            color: white;
            box-shadow: 0 4px 12px rgba(27,94,32,0.2);
        }

        .btn-action {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin: 0 2px;
            transition: 0.2s;
        }

        .btn-edit { background: rgba(27, 94, 32, 0.1); color: var(--cbta-green); }
        .btn-edit:hover { background: var(--cbta-green); color: white; }

        .btn-delete { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
        /*.btn-delete:hover { background: #dc3545; color: white; }*/

        .back-link {
            text-decoration: none;
            color: #888;
            font-weight: 500;
            transition: 0.3s;
        }

        .back-link:hover { color: var(--cbta-green); }
    </style>
</head>
<body>

<div class="container">
    <div class="main-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="header-title m-0">Gestión de Personas</h2>
            <a href="create.php" class="btn btn-add">
                <i class="fas fa-plus me-2"></i> Nuevo Registro
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="25%">Nombre</th>
                        <th width="25%">Apellidos</th>
                        <th width="20%">Carnet</th>
                        <th width="20%" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
include './../lib/db.php';

$stmt = $conn->prepare("SELECT * FROM personas");
$stmt->execute();
$result = $stmt->fetchAll();

foreach($result as $row) {
    echo "<tr>
            <td class='fw-bold text-muted'>#".$row['id']."</td>
            <td>".$row['nombre']."</td>
            <td>".$row['apellidos']."</td>
            <td><span class='badge bg-light text-dark border'>".$row['carnet']."</span></td>
            <td class='text-center'>
                <a href='edit.php?id=".$row['id']."' class='btn-action btn-edit' title='Editar'>
                    <i class='fas fa-pen-to-square'></i>
                </a>
                <button type='button' 
                        class='btn-action btn-delete btn-delete-confirm' 
                        data-id='".$row['id']."' 
                        title='Eliminar'
                        style='border:none; background:none;'>
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
            <a href="./.." class="back-link">
                <i class="fas fa-arrow-left me-1"></i> Regresar al Inicio
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
document.querySelectorAll('.btn-delete-confirm').forEach(button => {
    button.addEventListener('click', function(e) {
        const personaId = this.getAttribute('data-id');

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Este registro se eliminará de forma permanente",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1B5E20', // Verde institucional
            cancelButtonColor: '#d33',    // Rojo peligro
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            // Animación de entrada
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            // Animación de salida
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirección al archivo que procesa la eliminación
                window.location.href = `delete.php?id=${personaId}`;
            }
        });
    });
});
</script>
</body>
</html>
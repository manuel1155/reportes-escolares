<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Gestión de Grupos</title>
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
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
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
            font-size: 1.5rem;
            margin: 0;
            text-transform: uppercase;
        }

        .btn-register {
            background-color: var(--cbta-green);
            color: white;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .btn-register:hover {
            background-color: #144618;
            color: white;
            transform: translateY(-2px);
        }

        /* --- ESTILO DE TABLA MODERADA --- */
        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table thead th {
            border: none;
            color: #adb5bd;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px;
        }

        .table tbody tr {
            background-color: #fff;
            box-shadow: 0 3px 10px rgba(0,0,0,0.02);
            border-radius: 12px;
            transition: 0.2s;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border: none;
            font-size: 0.9rem;
        }

        .table tbody tr:hover {
            background-color: #fcfdfc;
            transform: scale(1.005);
        }

        /* --- BOTONES SUTILES DE ACCIÓN --- */
        .action-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-sutil {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            background: rgba(0,0,0,0.03); /* Fondo muy sutil */
        }

        /* Colores sutiles por tipo de acción */
        .btn-edit { color: var(--cbta-gold); }
        .btn-edit:hover { background: rgba(184, 134, 11, 0.15); }

        .btn-delete { color: #dc3545; }
        .btn-delete:hover { background: rgba(220, 53, 69, 0.15); }

        .btn-view { color: var(--cbta-green); }
        .btn-view:hover { background: rgba(27, 94, 32, 0.15); }

        /* Etiquetas sutiles */
        .badge-grado {
            background: var(--cbta-green);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.8rem;
        }

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

<div class="main-container animate__animated animate__fadeIn">
    <div class="header-flex">
        <h1><i class="fas fa-layer-group me-2"></i>Gestión de Grupos</h1>
        <a href="create.php" class="btn-register">
            <i class="fas fa-plus me-1"></i> Nuevo Grupo
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">Grado/Gpo</th>
                    <th width="15%">Periodo</th>
                    <th width="25%">Carrera</th>
                    <th width="25%">Tutor</th>
                    <th width="20%" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include './../lib/db.php';

                $sql = "SELECT g.id, g.grado, g.grupo, g.periodo, c.nombre AS nombre_carrera, 
                               CONCAT(t.nombre,' ',t.primer_apellido) AS nombre_tutor 
                        FROM grupos AS g 
                        INNER JOIN carreras AS c ON g.id_carrera = c.id 
                        INNER JOIN tutores AS t ON g.id_tutor = t.id 
                        WHERE g.activo = 1";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();

                foreach($result as $row) {
                    echo "<tr>
                            <td class='text-muted fw-bold'>#".$row['id']."</td>
                            <td>
                                <span class='badge-grado'>".$row['grado']."° ".$row['grupo']."</span>
                            </td>
                            <td>".$row['periodo']."</td>
                            <td class='fw-semibold'>".$row['nombre_carrera']."</td>
                            <td class='text-secondary small'>".$row['nombre_tutor']."</td>
                            <td>
                                <div class='action-group'>
                                    <a href='edit.php?id=".$row['id']."' class='btn-sutil btn-edit' title='Editar'>
                                        <i class='fas fa-pen-to-square'></i>
                                    </a>
                                    <button onclick='confirmDelete(".$row['id'].")' class='btn-sutil btn-delete' title='Eliminar'>
                                        <i class='fas fa-trash-can'></i>
                                    </button>
                                </div>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 pt-3 border-top">
        <a href="./.." class="btn-back">
            <i class="fas fa-arrow-left me-1"></i> Volver al Menú
        </a>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Eliminar grupo?',
        text: "El grupo será removido del sistema activo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1B5E20',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `delete.php?id=${id}`;
        }
    });
}
</script>

</body>
</html>
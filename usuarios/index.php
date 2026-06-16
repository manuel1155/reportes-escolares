<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Gestión de Usuarios</title>
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
            border-radius: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
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
            font-size: 1.4rem;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .btn-create {
            background-color: var(--cbta-green);
            color: white;
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
        }

        .btn-create:hover {
            background-color: #144618;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.2);
        }

        /* --- TABLA ESTILO TARJETA --- */
        .table {
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .table thead th {
            border: none;
            color: #999;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 10px 20px;
        }

        .table tbody tr {
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            border-radius: 15px;
            transition: 0.3s ease;
        }

        .table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            border: none;
            font-size: 0.9rem;
            color: #444;
        }

        .table tbody tr:hover {
            transform: scale(1.01);
            background-color: #fdfdfd;
        }

        /* --- BADGES DE ROL --- */
        .role-badge {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .role-admin { background: rgba(184, 134, 11, 0.1); color: var(--cbta-gold); }
        .role-maestro { background: rgba(27, 94, 32, 0.1); color: var(--cbta-green); }
        .role-prefectura { background: rgba(13, 110, 253, 0.1); color: #0d6efd; }

        /* --- ACCIONES --- */
        .action-btns {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            text-decoration: none;
            transition: 0.2s;
            border: none;
            background: #f8f9fa;
        }

        .btn-edit { color: var(--cbta-gold); }
        .btn-edit:hover { background: var(--cbta-gold); color: white; }

        .btn-delete { color: #dc3545; }
        .btn-delete:hover { background: #dc3545; color: white; }

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
        <h1><i class="fas fa-users-cog me-2"></i>Control de Usuarios</h1>
        <a href="create.php" class="btn-create">
            <i class="fas fa-user-plus me-2"></i> Registrar Nuevo
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="8%">ID</th>
                    <th width="20%">Email</th>
                    <th width="12%">Estado</th>
                    <th width="15%" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include './../lib/db.php';

                $stmt = $conn->prepare("SELECT * FROM usuarios WHERE activo = 1");
                $stmt->execute();
                $result = $stmt->fetchAll();

                foreach($result as $row) {
                   
                
                  echo "<tr>
                        <td class='fw-bold text-muted'>#".$row['id']."</td>

                        <td>   
                              <code class='text-primary'>".$row['email']."</code>
                        </td>
                                
                            
                        <td>
                         <span class='text-success small fw-bold'>
                        <i class='fas fa-circle me-1' style='font-size:8px;'></i>
                        Activo
                        </span>
                        </td>

                        <td>
                                <div class='action-btns'>
                                    <a href='edit.php?id=".$row['id']."' class='btn-action btn-edit' title='Editar'>
                                        <i class='fas fa-user-pen'></i>
                                    </a>
                                    <button onclick='confirmDelete(".$row['id'].")' class='btn-action btn-delete' title='Eliminar'>
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
        <a href="../inicio_dashboard.html" class="btn-back">
            <i class="fas fa-arrow-left me-1"></i> Regresar al inicio
        </a>

        </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: '¿Dar de baja usuario?',
        text: "El usuario perderá acceso al sistema inmediatamente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1B5E20',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Confirmar Baja',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `delete.php?id_usuario=${id}`;
        }
    });
}
</script>

</body>
</html>
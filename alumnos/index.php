<?php

session_start();

require_once './../lib/permisos.php';

validarPermiso('alumnos');


include './../lib/db.php';



// Ordenamos por apellido paterno para que sea un listado escolar natural
$stmt = $conn->prepare("SELECT * FROM alumnos ORDER BY primer_apellido ASC"); 
$stmt->execute();
$alumnos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Control de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --soft-gray: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            padding: 40px 20px;
        }

        .main-container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 35px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.05);
            border-top: 10px solid var(--cbta-green);
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h2 {
            font-weight: 800;
            color: var(--cbta-green);
            text-transform: uppercase;
            font-size: 1.5rem;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .btn-add-student {
            background-color: var(--cbta-green);
            color: white;
            border-radius: 15px;
            padding: 12px 25px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(27, 94, 32, 0.2);
        }

        .btn-add-student:hover {
            background-color: #144618;
            color: white;
            transform: translateY(-3px);
        }

        /* Estilo de Tabla Flotante */
        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table thead th {
            border: none;
            color: #999;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 10px 20px;
        }

        .table tbody tr {
            background-color: #fff;
            box-shadow: 0 3px 10px rgba(0,0,0,0.02);
            border-radius: 15px;
            transition: 0.2s;
        }

        .table tbody td {
            padding: 20px;
            vertical-align: middle;
            border: none;
            border-top: 1px solid #f8f9fa;
            border-bottom: 1px solid #f8f9fa;
        }

        .table tbody tr td:first-child { border-left: 1px solid #f8f9fa; border-radius: 15px 0 0 15px; }
        .table tbody tr td:last-child { border-right: 1px solid #f8f9fa; border-radius: 0 15px 15px 0; }

        .table tbody tr:hover {
            background-color: #fcfcfc;
            transform: scale(1.01);
        }

        .matricula-tag {
            background: rgba(184, 134, 11, 0.1);
            color: var(--cbta-gold);
            padding: 5px 12px;
            border-radius: 8px;
            font-family: monospace;
            font-weight: 700;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin: 0 2px;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-edit { background: #fff8e1; color: var(--cbta-gold); }
        .btn-edit:hover { background: var(--cbta-gold); color: white; }

        .btn-delete { background: #ffebee; color: #d32f2f; }
        .btn-delete:hover { background: #d32f2f; color: white; }

        .btn-back {
            color: #adb5bd;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .btn-back:hover { color: var(--cbta-gold); }
    </style>
</head>
<body>

<div class="main-container animate__animated animate__fadeIn">
    <div class="header-flex">
        <h2><i class="fas fa-users-viewfinder me-2"></i>Control de Alumnos</h2>
        <a href="create.php" class="btn-add-student">
            <i class="fas fa-plus-circle me-2"></i>Nuevo Alumno
        </a>
    </div>

        <div class="table-responsive">
             <table class="table">
              <thead>
            <tr>
                <th>No Control</th>
                <th>Nombre Completo</th>
                <th>curp</th>
                <th>Activo</th>
                <th>Acciones</th>
             </tr>
       
        </thead> 
        <tbody>
            <?php foreach($alumnos as $a): ?>
            <tr>

            <td>
            <span class="no-control-tag">
                  <?= htmlspecialchars($a['id']) ?>
            </span>
       </td>

       <td>
        <?= htmlspecialchars(
            $a['nombre'] . ' ' .
            $a['primer_apellido'] . ' ' .
            $a['segundo_apellido']
        ) ?>
        </td>

        <td>
        <?= htmlspecialchars($a['curp'] ) ?>
        </td>

    

    <td>
        <?= $a['activo'] == 1 ? 'Activo' : 'Inactivo' ?>
    </td>

    <td class="text-center">
        <a href="edit.php?id=<?= $a['id'] ?>" class="btn-action btn-edit">
            <i class="fas fa-user-pen"></i>
        </a>

        <a href="#"
           onclick="confirmarEliminar(<?= $a['id'] ?>)"
           class="btn-action btn-delete">
            <i class="fas fa-trash-alt"></i>
        </a>
    </td>

</tr>
<?php endforeach; ?>
</tbody>
        </table>
    </div>

    <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items: center">
        <a href="../" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i>Regresar al Menú
        </a>
        <span class="text-muted small">Total: <strong><?= count($alumnos) ?></strong> alumnos registrados</span>
    </div>
</div>

<script>
function confirmarEliminar(id) {
    Swal.fire({
        title: '¿Eliminar alumno?',
        text: "Se borrará permanentemente el expediente y todo su historial.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
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
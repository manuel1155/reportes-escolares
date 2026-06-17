<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('inscripciones');

include './../lib/db.php';

$id_grupo = $_GET['grupo'] ?? null;

$grupoSeleccionado = null;
$alumnos = [];
$grupos = [];

// Obtener grupos activos
$sql = "SELECT g.id, CONCAT( g.grado,'° ', g.grupo,' - ', c.nombre, ' (',g.periodo,')' ) descripcion FROM grupos g INNER JOIN carreras c ON c.id = g.id_carrera WHERE g.activo = 1 ORDER BY g.periodo DESC, g.grado, c.nombre, g.grupo;";

$stmt = $conn->prepare($sql);
$stmt->execute();
$grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($id_grupo) {

    // Información del grupo
    $sqlGrupo = "
        SELECT
            g.*,
            c.nombre AS carrera,
            CONCAT(
                t.nombre,' ',
                t.primer_apellido,' ',
                t.segundo_apellido
            ) AS tutor
        FROM grupos g
        INNER JOIN carreras c
            ON c.id = g.id_carrera
        INNER JOIN tutores t
            ON t.id = g.id_tutor
        WHERE g.id = :id
    ";

    $stmtGrupo = $conn->prepare($sqlGrupo);
$stmtGrupo->bindParam(':id', $id_grupo);
$stmtGrupo->execute();

$grupoSeleccionado = $stmtGrupo->fetch(PDO::FETCH_ASSOC);

// Validar que el grupo exista
if (!$grupoSeleccionado) {
    header('Location: ./inscripciones');
    exit;
}

    // Alumnos inscritos
    $sqlAlumnos = "
        SELECT
            i.id AS id_inscripcion,
            a.id,
            CONCAT(
                a.primer_apellido,' ',
                a.segundo_apellido,' ',
                a.nombre
            ) AS nombre_completo
        FROM inscripciones i
        INNER JOIN alumnos a
            ON a.id = i.id_alumno
        WHERE
            i.id_grupo = :id_grupo
            AND i.activo = 1
        ORDER BY
            a.primer_apellido,
            a.segundo_apellido,
            a.nombre
    ";

    $stmtAlumnos = $conn->prepare($sqlAlumnos);
    $stmtAlumnos->bindParam(':id_grupo', $id_grupo);
    $stmtAlumnos->execute();

    $alumnos = $stmtAlumnos->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CBTa 159 | Gestión de Inscripciones</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

:root{
    --cbta-green:#1B5E20;
    --cbta-gold:#B8860B;
    --bg-light:#f8f9fa;
}

body{
    font-family:'Inter',sans-serif;
    background-color:var(--bg-light);
    padding:40px 20px;
}

.main-container{
    max-width:1200px;
    margin:auto;
    background:white;
    padding:35px;
    border-radius:24px;
    box-shadow:0 10px 30px rgba(0,0,0,0.03);
    border-top:8px solid var(--cbta-green);
}

h1{
    color:var(--cbta-green);
    font-weight:800;
    text-transform:uppercase;
    font-size:1.5rem;
}

.card-info{
    border:none;
    border-radius:16px;Por favor, coinci
    box-shadow:0 4px 15px rgba(0,0,0,0.03);
}

.table{
    border-collapse:separate;
    border-spacing:0 10px;
}

.table tbody tr{
    background:white;
    box-shadow:0 3px 10px rgba(0,0,0,0.03);
}

.table td{
    border:none;
    padding:15px;
}

.table th{
    border:none;
    font-size:.75rem;
    color:#adb5bd;
    text-transform:uppercase;
}

.btn-cbta{
    background:var(--cbta-green);
    color:white;
    border:none;
}

.btn-cbta:hover{
    background:#144618;
    color:white;
}

.badge-total{
    background:var(--cbta-gold);
    color:white;
    padding:6px 12px;
    border-radius:8px;
}

</style>
</head>
<body>

<div class="main-container animate__animated animate__fadeIn">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="fas fa-user-graduate me-2"></i>
            Gestión de Inscripciones
        </h1>
    </div>

    <!-- Selección de Grupo -->
    <form method="GET" class="mb-4">

        <label class="form-label fw-bold">
            Seleccione un Grupo
        </label>

        <div class="input-group">

            <select
                name="grupo"
                class="form-select"
                required>

                <option value="">
                    -- Seleccione --
                </option>

                <?php foreach($grupos as $grupo): ?>

                    <option
                        value="<?= $grupo['id']; ?>"
                        <?= ($id_grupo == $grupo['id']) ? 'selected' : ''; ?>>

                        <?= htmlspecialchars($grupo['descripcion']); ?>

                    </option>

                <?php endforeach; ?>

            </select>

            <button
                class="btn btn-cbta"
                type="submit">

                Consultar

            </button>

        </div>

    </form>

    <?php if($grupoSeleccionado): ?>

        <!-- Datos Grupo -->

        <div class="card card-info mb-4">
            <div class="card-body">

                <div class="row">

    <div class="col-md-2">
        <strong>Grupo</strong><br>
        <?= htmlspecialchars($grupoSeleccionado['grado']); ?>°
        <?= htmlspecialchars($grupoSeleccionado['grupo']); ?>
    </div>

    <div class="col-md-3">
        <strong>Carrera</strong><br>
        <?= htmlspecialchars($grupoSeleccionado['carrera']); ?>
    </div>

    <div class="col-md-3">
        <strong>Tutor</strong><br>
        <?= htmlspecialchars($grupoSeleccionado['tutor']); ?>
    </div>

    <div class="col-md-2">
        <strong>Periodo</strong><br>
        <?= htmlspecialchars($grupoSeleccionado['periodo']); ?>
    </div>

    <div class="col-md-2">
        <strong>Total Inscritos</strong><br>

        <span class="badge-total">
            <?= count($alumnos); ?>
        </span>
    </div>

</div>

            </div>
        </div>

        <!-- Formulario Alta -->

        <div class="card card-info mb-4">

    <div class="card-body">

        <form
            id="formInscripcion"
            action="store.php"
            method="POST">

            <input
                type="hidden"
                name="id_grupo"
                value="<?= $grupoSeleccionado['id']; ?>">

            <div class="row">

                <div class="col-md-7">

                    <label class="form-label">
                        Número de Control
                    </label>

                    <input
                        type="text"
                        name="id_alumno"
                        class="form-control"
                        maxlength="14"
                        minlength="14"
                        pattern="[0-9]{14}"
                        title="El número de control debe contener exactamente 14 dígitos númericos"
                        required>

                </div>

                <div class="col-md-2 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-cbta w-100">

                        <i class="fas fa-user-check me-2"></i>
                        Validar

                    </button>

                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <a
                        href="carga_masiva.php?grupo=<?= $grupoSeleccionado['id']; ?>"
                        class="btn btn-success w-100">

                        <i class="fas fa-file-excel me-2"></i>
                        Carga Masiva

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

        
        <!-- Tabla -->

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>
                        <th>Item</th>
                        <th>No. Control</th>
                        <th>Alumno</th>
                        <th width="10%">Acción</th>
                    </tr>

                </thead>

                <tbody>

<?php if(count($alumnos) > 0): ?>

    <?php $i = 1; foreach($alumnos as $alumno): ?>

        <tr>

            <td>
                <?= $i; ?>
            </td>

            <td>
                <?= $alumno['id']; ?>
            </td>

            <td>
                <?= htmlspecialchars($alumno['nombre_completo']); ?>
            </td>

            <td>

                <button
                    onclick="confirmDelete(<?= $alumno['id_inscripcion']; ?>)"
                    class="btn btn-sm btn-outline-danger">

                    <i class="fas fa-trash"></i>

                </button>

            </td>

        </tr>

    <?php $i++; endforeach; ?>

<?php else: ?>

    <tr class="table-empty">

        <td colspan="4" class="text-center py-4 text-muted">

            <i class="fas fa-users-slash me-2"></i>
            No hay alumnos inscritos en este grupo.

        </td>

    </tr>

<?php endif; ?>

</tbody>

            </table>

        </div>

    <?php endif; ?>

</div>

<script>

function confirmDelete(id){

    Swal.fire({
        title:'¿Dar de baja inscripción?',
        text:'El alumno será removido del grupo activo.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#1B5E20',
        cancelButtonColor:'#dc3545',
        confirmButtonText:'Sí, dar de baja'
    }).then((result)=>{

        if(result.isConfirmed){

            window.location.href='./delete.php?id='+id;

        }

    });

}

document.getElementById('formInscripcion').addEventListener('submit', function(e){

    const numeroControl = document.querySelector('[name="id_alumno"]').value.trim();

    if(!/^\d{14}$/.test(numeroControl)){

        e.preventDefault();

        Swal.fire({
            icon: 'error',
            title: 'Número de control inválido',
            text: 'El número de control debe contener exactamente 14 dígitos.'
        });

        return false;
    }

});

</script>

</body>
</html>
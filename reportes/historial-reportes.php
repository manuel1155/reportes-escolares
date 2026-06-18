<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('reportes');

include './../lib/db.php';

/*
|--------------------------------------------------------------------------
| FECHAS POR DEFECTO
|--------------------------------------------------------------------------
*/

$fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
$fecha_fin    = $_GET['fecha_fin'] ?? date('Y-m-d');

/*
|--------------------------------------------------------------------------
| CONSULTA REPORTES
|--------------------------------------------------------------------------
*/

$sql = "
SELECT

    r.id,
    r.fecha_hora,

    a.id AS numero_control,

    CONCAT(
        a.primer_apellido,' ',
        a.segundo_apellido,' ',
        a.nombre
    ) AS alumno,

    CONCAT(
        g.grado,'° ',
        g.grupo
    ) AS grupo,

    CONCAT(
        t.nombre,' ',
        t.primer_apellido
    ) AS tutor,

    c.descripcion AS causa

FROM reportes r

INNER JOIN inscripciones i
    ON i.id = r.id_inscripcion

INNER JOIN alumnos a
    ON a.id = i.id_alumno

INNER JOIN grupos g
    ON g.id = i.id_grupo

INNER JOIN tutores t
    ON t.id = g.id_tutor

INNER JOIN causas c
    ON c.id = r.id_causa

WHERE
    r.activo = 1
    AND DATE(r.fecha_hora)
        BETWEEN :fecha_inicio
        AND :fecha_fin

ORDER BY r.fecha_hora DESC
";

$stmt = $conn->prepare($sql);

$stmt->bindParam(':fecha_inicio', $fecha_inicio);
$stmt->bindParam(':fecha_fin', $fecha_fin);

$stmt->execute();

$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| INDICADORES
|--------------------------------------------------------------------------
*/

$totalReportes = count($reportes);

$alumnosDistintos = [];

foreach ($reportes as $reporte) {
    $alumnosDistintos[$reporte['numero_control']] = true;
}

$totalAlumnos = count($alumnosDistintos);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Historial de Reportes</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<!-- DATATABLES -->

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>

:root{
    --cbta-green:#1B5E20;
    --cbta-gold:#B8860B;
    --bg-light:#f8f9fa;
}

body{
    font-family:'Inter',sans-serif;
    background:var(--bg-light);
    padding:40px 20px;
}

.main-container{
    max-width:1400px;
    margin:auto;
    background:white;
    padding:35px;
    border-radius:24px;
    box-shadow:0 10px 30px rgba(0,0,0,.03);
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
    border-radius:16px;
    box-shadow:0 4px 15px rgba(0,0,0,.04);
}

.card-stat{
    border:none;
    border-radius:16px;
    padding:25px;
    text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,.04);
}

.card-stat h2{
    color:var(--cbta-green);
    font-weight:800;
    margin-top:10px;
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

.table{
    margin-bottom:0;
}


.badge-causa{
    background:var(--cbta-gold);
    color:white;
    padding:6px 10px;
    border-radius:8px;
}



</style>

</head>

<body>

<div class="main-container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>

            <i class="fas fa-calendar-days me-2"></i>

            Historial de Reportes

        </h1>

        <a
            href="index.php"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Regresar

        </a>

    </div>

    <!-- FILTROS -->

    <div class="card card-info mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">
                            Fecha Inicial
                        </label>

                        <input
                            type="date"
                            name="fecha_inicio"
                            class="form-control"
                            value="<?= $fecha_inicio; ?>"
                            required>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Fecha Final
                        </label>

                        <input
                            type="date"
                            name="fecha_fin"
                            class="form-control"
                            value="<?= $fecha_fin; ?>"
                            required>

                    </div>

                    <div class="col-md-4 d-flex align-items-end">

                        <button
                            class="btn btn-cbta w-100">

                            <i class="fas fa-search me-2"></i>

                            Consultar

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- INDICADORES -->

    <div class="row mb-4">

        <div class="col-md-6">

            <div class="card-stat">

                <small class="text-muted">
                    Total Reportes
                </small>

                <h2>
                    <?= $totalReportes; ?>
                </h2>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card-stat">

                <small class="text-muted">
                    Alumnos Distintos
                </small>

                <h2>
                    <?= $totalAlumnos; ?>
                </h2>

            </div>

        </div>

    </div>

    <!-- TABLA -->

    <div class="card card-info">

        <div class="card-body">

            <?php if(empty($reportes)): ?>

                <div class="alert alert-success">

                    No se encontraron reportes para el periodo seleccionado.

                </div>

            <?php else: ?>

                <div class="table-container">

                    <table id="tablaReportes" class="table table-hover">

                        <thead>

                            <tr>

                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>No. Control</th>
                                <th>Alumno</th>
                                <th>Grupo</th>
                                <th>Tutor</th>
                                <th>Causa</th>
                                <th>Acción</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($reportes as $reporte): ?>

                                <tr>

                                    <td>
                                        <?= $reporte['id']; ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime($reporte['fecha_hora'])
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'H:i',
                                            strtotime($reporte['fecha_hora'])
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= $reporte['numero_control']; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($reporte['alumno']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($reporte['grupo']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($reporte['tutor']); ?>
                                    </td>

                                    <td>

                                        <span class="badge-causa">

                                            <?= htmlspecialchars($reporte['causa']); ?>

                                        </span>

                                    </td>

                                    <td>

                                        <a
                                            href="detalle.php?id=<?= $reporte['id']; ?>"
                                            class="btn btn-sm btn-outline-primary">

                                            <i class="fas fa-eye"></i>

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function(){

    $('#tablaReportes').DataTable({

        pageLength: 25,

        order: [[1, 'desc'], [2, 'desc']],

        language: {

            decimal: "",
            emptyTable: "No hay información",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros)",
            lengthMenu: "Mostrar _MENU_ registros",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "No se encontraron resultados",

            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }

        }

    });

});

</script>

</body>
</html>
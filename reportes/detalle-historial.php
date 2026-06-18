<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('reportes');

include './../lib/db.php';

/*
|--------------------------------------------------------------------------
| VALIDAR PARÁMETRO
|--------------------------------------------------------------------------
*/

$id_alumno = $_GET['id'] ?? null;

if (!$id_alumno) {

    header("Location: historial-alumnos.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| DATOS DEL ALUMNO
|--------------------------------------------------------------------------
*/

$sqlAlumno = "

SELECT

    a.id,

    CONCAT(
        a.primer_apellido,' ',
        a.segundo_apellido,' ',
        a.nombre
    ) AS alumno,

    CONCAT(
        g.grado,'° ',
        g.grupo
    ) AS grupo,

    c.nombre AS carrera,

    CONCAT(
        t.nombre,' ',
        t.primer_apellido
    ) AS tutor

FROM alumnos a

LEFT JOIN inscripciones i
    ON i.id_alumno = a.id
    AND i.activo = 1

LEFT JOIN grupos g
    ON g.id = i.id_grupo

LEFT JOIN carreras c
    ON c.id = g.id_carrera

LEFT JOIN tutores t
    ON t.id = g.id_tutor

WHERE
    a.id = :id
    AND a.activo = 1

LIMIT 1

";

$stmtAlumno = $conn->prepare($sqlAlumno);
$stmtAlumno->bindParam(':id', $id_alumno);
$stmtAlumno->execute();

$alumno = $stmtAlumno->fetch(PDO::FETCH_ASSOC);

if (!$alumno) {

    header("Location: historial-alumnos.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| HISTORIAL DE REPORTES
|--------------------------------------------------------------------------
*/

$sqlHistorial = "

SELECT

    r.id,
    r.fecha_hora,
    ca.descripcion,
    r.observaciones

FROM reportes r

INNER JOIN inscripciones i
    ON i.id = r.id_inscripcion

INNER JOIN causas ca
    ON ca.id = r.id_causa

WHERE
    i.id_alumno = :id_alumno
    AND r.activo = 1

ORDER BY
    r.fecha_hora DESC

";

$stmtHistorial = $conn->prepare($sqlHistorial);
$stmtHistorial->bindParam(':id_alumno', $id_alumno);
$stmtHistorial->execute();

$historial = $stmtHistorial->fetchAll(PDO::FETCH_ASSOC);

$totalReportes = count($historial);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Historial Disciplinario</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    background-color:var(--bg-light);
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
    padding:20px;
    text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,.04);
}

.card-stat h2{
    color:var(--cbta-green);
    font-weight:800;
}

.badge-total{
    background:var(--cbta-gold);
    color:white;
    padding:8px 14px;
    border-radius:10px;
}

</style>

</head>

<body>

<div class="main-container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>

            <i class="fas fa-user-clock me-2"></i>

            Historial Disciplinario

        </h1>

        <a
            href="historial-alumnos.php"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Regresar

        </a>

    </div>

    <!-- DATOS DEL ALUMNO -->

    <div class="card card-info mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>Alumno</strong><br>

                    <?= htmlspecialchars($alumno['alumno']); ?>

                </div>

                <div class="col-md-2 mb-3">

                    <strong>No. Control</strong><br>

                    <?= $alumno['id']; ?>

                </div>

                <div class="col-md-2 mb-3">

                    <strong>Grupo Actual</strong><br>

                    <?= htmlspecialchars($alumno['grupo'] ?? 'Sin grupo'); ?>

                </div>

                <div class="col-md-2 mb-3">

                    <strong>Carrera</strong><br>

                    <?= htmlspecialchars($alumno['carrera'] ?? 'N/A'); ?>

                </div>

                <div class="col-md-2 mb-3">

                    <strong>Tutor</strong><br>

                    <?= htmlspecialchars($alumno['tutor'] ?? 'N/A'); ?>

                </div>

            </div>

        </div>

    </div>

    <!-- INDICADOR -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card-stat">

                <small class="text-muted">

                    Total Reportes

                </small>

                <h2>

                    <?= $totalReportes; ?>

                </h2>

            </div>

        </div>

    </div>

    <!-- HISTORIAL -->

    <div class="card card-info">

        <div class="card-body">

            <?php if(empty($historial)): ?>

                <div class="alert alert-success">

                    El alumno no cuenta con reportes registrados.

                </div>

            <?php else: ?>

                <table
                    id="tablaHistorial"
                    class="table table-hover">

                    <thead>

                        <tr>

                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Causa</th>
                            <th>Observaciones</th>
                            <th>Acción</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($historial as $r): ?>

                            <tr>

                                <td>

                                    <?= $r['id']; ?>

                                </td>

                                <td>

                                    <?= date(
                                        'd/m/Y',
                                        strtotime($r['fecha_hora'])
                                    ); ?>

                                </td>

                                <td>

                                    <?= date(
                                        'H:i',
                                        strtotime($r['fecha_hora'])
                                    ); ?>

                                </td>

                                <td>

                                    <?= htmlspecialchars($r['descripcion']); ?>

                                </td>

                                <td>

                                    <?= htmlspecialchars(
                                        mb_strimwidth(
                                            $r['observaciones'],
                                            0,
                                            80,
                                            '...'
                                        )
                                    ); ?>

                                </td>

                                <td>

                                    <a
                                        href="detalle.php?id=<?= $r['id']; ?>"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            <?php endif; ?>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function(){

    $('#tablaHistorial').DataTable({

        pageLength: 25,

        order: [[0,'desc']],

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
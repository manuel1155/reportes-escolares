<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('reportes');

include './../lib/db.php';

/*
|--------------------------------------------------------------------------
| TOTAL REPORTES DEL DÍA
|--------------------------------------------------------------------------
*/

$sqlTotal = "
    SELECT COUNT(*) total
    FROM reportes
    WHERE
        DATE(fecha_hora) = CURDATE()
        AND activo = 1
";

$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->execute();

$totalReportes = $stmtTotal->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| TOTAL DE ALUMNOS DISTINTOS REPORTADOS HOY
|--------------------------------------------------------------------------
*/

$sqlAlumnos = "
    SELECT COUNT(DISTINCT i.id_alumno) total
    FROM reportes r
    INNER JOIN inscripciones i
        ON i.id = r.id_inscripcion
    WHERE
        DATE(r.fecha_hora) = CURDATE()
        AND r.activo = 1
";

$stmtAlumnos = $conn->prepare($sqlAlumnos);
$stmtAlumnos->execute();

$totalAlumnos = $stmtAlumnos->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| REPORTES DEL DÍA
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
            t.primer_apellido,' ',
            t.segundo_apellido
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
        DATE(r.fecha_hora) = CURDATE()
        AND r.activo = 1

    ORDER BY r.fecha_hora DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute();

$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CBTa 159 | Reportes Disciplinarios</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

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
    font-size:1.6rem;
}

.card-stat{
    border:none;
    border-radius:16px;
    text-align:center;
    padding:25px;
    box-shadow:0 4px 15px rgba(0,0,0,.05);
    height:100%;
}

.card-stat h2{
    color:var(--cbta-green);
    font-weight:800;
    margin-top:10px;
}

.card-info{
    border:none;
    border-radius:16px;
    box-shadow:0 4px 15px rgba(0,0,0,.05);
}

.table{
    border-collapse:separate;
    border-spacing:0 10px;
}

.table tbody tr{
    background:white;
    box-shadow:0 3px 10px rgba(0,0,0,.03);
}

.table td{
    border:none;
    padding:15px;
    vertical-align:middle;
}

.table th{
    border:none;
    color:#adb5bd;
    font-size:.75rem;
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

.badge-causa{
    background:var(--cbta-gold);
    color:white;
    padding:6px 10px;
    border-radius:8px;
    font-size:.80rem;
}

</style>

</head>

<body>

<div class="main-container animate__animated animate__fadeIn">

    <!-- Encabezado -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            <i class="fas fa-triangle-exclamation me-2"></i>
            Reportes Disciplinarios
        </h1>

        <a
            href="generar-reporte.php"
            class="btn btn-cbta">

            <i class="fas fa-plus me-2"></i>
            Nuevo Reporte

        </a>

    </div>

    <!-- Indicadores -->

    <div class="row mb-4">

        <div class="col-md-6">

            <div class="card-stat">

                <small class="text-muted">
                    Reportes Registrados Hoy
                </small>

                <h2>
                    <?= $totalReportes['total']; ?>
                </h2>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card-stat">

                <small class="text-muted">
                    Alumnos Reportados Hoy
                </small>

                <h2>
                    <?= $totalAlumnos['total']; ?>
                </h2>

            </div>

        </div>

    </div>

    <!-- Accesos rápidos -->

    <div class="mb-4">

        <a
            href="historial-reportes.php"
            class="btn btn-outline-secondary">

            <i class="fas fa-calendar-days me-2"></i>
            Historial por Fechas

        </a>

        <a
            href="historial-alumnos.php"
            class="btn btn-outline-secondary">

            <i class="fas fa-user-graduate me-2"></i>
            Historial por Alumno

        </a>

        <a
            href="historial-reportes.php"
            class="btn btn-outline-secondary">

            <i class="fas fa-users me-2"></i>
            Historial por Grupo

        </a>

    </div>

    <!-- Reportes del día -->

    <div class="card card-info">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">
                    Reportes Registrados Hoy
                </h5>

                <span class="badge bg-success">
                    <?= count($reportes); ?> registros
                </span>

            </div>

            <?php if(empty($reportes)): ?>

                <div class="alert alert-success mb-0">

                    <i class="fas fa-check-circle me-2"></i>

                    No existen reportes registrados el día de hoy.

                </div>

            <?php else: ?>

                <div class="table-responsive">

                    <table class="table">

                        <thead>

                            <tr>

                                <th>Hora</th>
                                <th>No. Control</th>
                                <th>Alumno</th>
                                <th>Grupo</th>
                                <th>Tutor</th>
                                <th>Causa</th>
                                <th width="8%">Acción</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($reportes as $reporte): ?>

                                <tr>

                                    <td>

                                        <?= date(
                                            'H:i',
                                            strtotime($reporte['fecha_hora'])
                                        ); ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($reporte['numero_control']); ?>

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
                                            class="btn btn-sm btn-outline-primary"
                                            title="Ver detalle">

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

</body>
</html>
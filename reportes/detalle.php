<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('reportes');

include './../lib/db.php';

/*
|--------------------------------------------------------------------------
| VALIDAR ID
|--------------------------------------------------------------------------
*/

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {

    header("Location: index.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| CONSULTAR REPORTE
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT

        r.id,
        r.fecha_hora,
        r.observaciones,

        c.descripcion AS causa,

        u.email AS usuario,

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

        crr.nombre AS carrera,

        CONCAT(
            t.nombre,' ',
            t.primer_apellido,' ',
            t.segundo_apellido
        ) AS tutor

    FROM reportes r

    INNER JOIN inscripciones i
        ON i.id = r.id_inscripcion

    INNER JOIN alumnos a
        ON a.id = i.id_alumno

    INNER JOIN grupos g
        ON g.id = i.id_grupo

    INNER JOIN carreras crr
        ON crr.id = g.id_carrera

    INNER JOIN tutores t
        ON t.id = g.id_tutor

    INNER JOIN causas c
        ON c.id = r.id_causa

    INNER JOIN usuarios u
        ON u.id = r.id_usuario

    WHERE
        r.id = :id
        AND r.activo = 1
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$reporte = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reporte) {

    header("Location: index.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detalle del Reporte</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    max-width:1000px;
    margin:auto;
    background:white;
    padding:35px;
    border-radius:24px;
    box-shadow:0 10px 30px rgba(0,0,0,.04);
    border-top:8px solid var(--cbta-green);
}

h1{
    color:var(--cbta-green);
    font-size:1.6rem;
    font-weight:800;
}

.card-info{
    border:none;
    border-radius:16px;
    box-shadow:0 4px 15px rgba(0,0,0,.04);
}

.label{
    font-size:.8rem;
    color:#6c757d;
    text-transform:uppercase;
    font-weight:600;
}

.value{
    font-size:1rem;
    font-weight:600;
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

.observaciones{
    min-height:150px;
    white-space:pre-wrap;
}

</style>

</head>

<body>

<div class="main-container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>

            <i class="fas fa-file-alt me-2"></i>

            Detalle del Reporte #<?= $reporte['id']; ?>

        </h1>

    </div>

    <!-- DATOS DEL REPORTE -->

    <div class="card card-info mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <div class="label">
                        Fecha y Hora
                    </div>

                    <div class="value">
                        <?= date(
                            'd/m/Y H:i',
                            strtotime($reporte['fecha_hora'])
                        ); ?>
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="label">
                        Usuario
                    </div>

                    <div class="value">
                        <?= htmlspecialchars($reporte['usuario']); ?>
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="label">
                        Causa
                    </div>

                    <div class="value">
                        <?= htmlspecialchars($reporte['causa']); ?>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- DATOS DEL ALUMNO -->

    <div class="card card-info mb-4">

        <div class="card-body">

            <h5 class="mb-4">
                Datos del Alumno
            </h5>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <div class="label">
                        Número de Control
                    </div>

                    <div class="value">
                        <?= $reporte['numero_control']; ?>
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <div class="label">
                        Alumno
                    </div>

                    <div class="value">
                        <?= htmlspecialchars($reporte['alumno']); ?>
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="label">
                        Grupo
                    </div>

                    <div class="value">
                        <?= htmlspecialchars($reporte['grupo']); ?>
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="label">
                        Carrera
                    </div>

                    <div class="value">
                        <?= htmlspecialchars($reporte['carrera']); ?>
                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="label">
                        Tutor
                    </div>

                    <div class="value">
                        <?= htmlspecialchars($reporte['tutor']); ?>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- OBSERVACIONES -->

    <div class="card card-info mb-4">

        <div class="card-body">

            <h5 class="mb-3">
                Observaciones
            </h5>

            <div class="observaciones">

                <?= nl2br(htmlspecialchars($reporte['observaciones'])); ?>

            </div>

        </div>

    </div>

    <!-- BOTONES -->

    <div class="d-flex justify-content-between">

        <a
            href="index.php"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left me-2"></i>
            Regresar

        </a>

        <button
            onclick="window.print();"
            class="btn btn-cbta">

            <i class="fas fa-print me-2"></i>
            Imprimir

        </button>

    </div>

</div>

</body>
</html>
<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('inscripciones');

include './../lib/db.php';

/*
|--------------------------------------------------------------------------
| VALIDAR GRUPO
|--------------------------------------------------------------------------
*/

$id_grupo = $_GET['grupo'] ?? null;

if (!$id_grupo || !is_numeric($id_grupo)) {

    header("Location: index.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| OBTENER INFORMACIÓN DEL GRUPO
|--------------------------------------------------------------------------
*/

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
    WHERE
        g.id = :id
        AND g.activo = 1
";

$stmtGrupo = $conn->prepare($sqlGrupo);
$stmtGrupo->bindParam(':id', $id_grupo);
$stmtGrupo->execute();

$grupo = $stmtGrupo->fetch(PDO::FETCH_ASSOC);

if (!$grupo) {

    header("Location: index.php");
    exit;

}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CBTa 159 | Carga Masiva de Inscripciones</title>

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
    max-width:1000px;
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
    box-shadow:0 4px 15px rgba(0,0,0,.03);
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

.example-box{
    background:#f8f9fa;
    border:1px solid #dee2e6;
    border-radius:10px;
    padding:15px;
    font-family:monospace;
    white-space:pre-line;
}

</style>

</head>

<body>

<div class="main-container animate__animated animate__fadeIn">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            <i class="fas fa-file-csv me-2"></i>
            Carga Masiva de Inscripciones
        </h1>

    </div>

    <!-- Información del grupo -->

    <div class="card card-info mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">

                    <strong>Grado y Grupo</strong><br>

                    <?= $grupo['grado']; ?>°
                    <?= htmlspecialchars($grupo['grupo']); ?>

                </div>

                <div class="col-md-3">

                    <strong>Carrera</strong><br>

                    <?= htmlspecialchars($grupo['carrera']); ?>

                </div>

                <div class="col-md-3">

                    <strong>Tutor</strong><br>

                    <?= htmlspecialchars($grupo['tutor']); ?>

                </div>

                <div class="col-md-3">

                    <strong>Periodo</strong><br>

                    <?= htmlspecialchars($grupo['periodo']); ?>

                </div>

            </div>

        </div>

    </div>

    <!-- Formulario -->

    <div class="card card-info">

        <div class="card-body">

            <form
                action="validar_csv.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="id_grupo"
                    value="<?= $grupo['id']; ?>">

                <div class="mb-4">

                    <label class="form-label fw-bold">
                        Archivo CSV
                    </label>

                    <input
                        type="file"
                        name="archivo_csv"
                        class="form-control"
                        accept=".csv"
                        required>

                    <div class="form-text">
                        Formato permitido: .csv
                    </div>

                </div>

                <div class="alert alert-info">

                    <h6>
                        <i class="fas fa-circle-info me-2"></i>
                        Instrucciones
                    </h6>

                    <ol class="mb-0">
                        <li>
                            Descarga el archivo.
                            <a href="./plantilla_inscripciones.csv"> <button
                        type="button"
                        class="btn btn-primary">
                        <i class="fas fa-regular fa-file"></i>
                        plantilla_inscripciones.csv</button></a>
                        </li>
                        <li>
                            Abre el archivo con Excel.
                        </li>
                        <li>
                            Capturar un número de control por fila.
                        </li>

                        <li>
                            Guardar el archivo como:
                            <strong>CSV UTF-8 (delimitado por comas)</strong>.
                        </li>

                        <li>
                            Seleccionar el archivo y presionar
                            <strong>Validar Archivo</strong>.
                        </li>

                    </ol>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-bold">
                        Ejemplo de contenido esperado
                    </label>

                    <div class="example-box">
No Control
23124011590166
23124011590167
23124011590168
23124011590169
                    </div>

                </div>

                <div class="d-flex justify-content-between">

                    <a
                        href="index.php?grupo=<?= $grupo['id']; ?>"
                        class="btn btn-secondary">

                        <i class="fas fa-arrow-left me-2"></i>
                        Regresar

                    </a>

                    <button
                        type="submit"
                        class="btn btn-cbta">

                        <i class="fas fa-check-circle me-2"></i>
                        Validar Archivo

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>
<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('inscripciones');

include './../lib/db.php';
echo 'Validando...';

/*
|--------------------------------------------------------------------------
| CONFIRMAR INSCRIPCIÓN
|--------------------------------------------------------------------------
*/
if (isset($_POST['confirmar'])) {

    $id_grupo  = trim($_POST['id_grupo']);
    $id_alumno = trim($_POST['id_alumno']);

    try {

        // Validar nuevamente que el alumno no tenga inscripción activa
        $sqlValidar = "
            SELECT id
            FROM inscripciones
            WHERE
                id_alumno = :id_alumno
                AND activo = 1
            LIMIT 1
        ";

        $stmtValidar = $conn->prepare($sqlValidar);
        $stmtValidar->bindParam(':id_alumno', $id_alumno);
        $stmtValidar->execute();

        if ($stmtValidar->fetch()) {

            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Inscripción duplicada',
                    text: 'El alumno ya tiene una inscripción activa.'
                }).then(() => {
                    window.location.href='./inscripciones/index.php?grupo={$id_grupo}';
                });
            </script>";
            exit;
        }

        // Registrar inscripción
        $sqlInsert = "
            INSERT INTO inscripciones
            (
                id_alumno,
                id_grupo,
                f_registro,
                activo
            )
            VALUES
            (
                :id_alumno,
                :id_grupo,
                NOW(),
                1
            )
        ";

        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':id_alumno', $id_alumno);
        $stmtInsert->bindParam(':id_grupo', $id_grupo);
        $stmtInsert->execute();

        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Inscripción realizada',
                text: 'El alumno fue inscrito correctamente.'
            }).then(() => {
                window.location.href='index.php?grupo={$id_grupo}';
            });
        </script>";
        exit;

    } catch (PDOException $e) {
        var_dump($e);

        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No fue posible registrar la inscripción.'
            }).then(() => {
                window.location.href='index.php?grupo={$id_grupo}';
            });
        </script>";
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| VALIDAR DATOS
|--------------------------------------------------------------------------
*/
$id_grupo  = trim($_POST['id_grupo'] ?? '');
$id_alumno = trim($_POST['id_alumno'] ?? '');

/*
|--------------------------------------------------------------------------
| VALIDAR NÚMERO DE CONTROL
|--------------------------------------------------------------------------
*/
if (!preg_match('/^\d{14}$/', $id_alumno)) {

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Número de control inválido',
            text: 'Debe contener exactamente 14 dígitos.'
        }).then(() => {
            window.location.href='index.php?grupo={$id_grupo}';
        });
    </script>";
    exit;
}

/*
|--------------------------------------------------------------------------
| VALIDAR GRUPO
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

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Grupo inválido',
            text: 'El grupo seleccionado no existe.'
        }).then(() => {
            window.location.href='index.php';
        });
    </script>";
    exit;
}

/*
|--------------------------------------------------------------------------
| VALIDAR ALUMNO
|--------------------------------------------------------------------------
*/
$sqlAlumno = "
    SELECT *
    FROM alumnos
    WHERE
        id = :id
        AND activo = 1
";

$stmtAlumno = $conn->prepare($sqlAlumno);
$stmtAlumno->bindParam(':id', $id_alumno);
$stmtAlumno->execute();

$alumno = $stmtAlumno->fetch(PDO::FETCH_ASSOC);

if (!$alumno) {

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Alumno no encontrado',
            text: 'No existe un alumno activo con el número de control {$id_alumno}.'
        }).then(() => {
            window.location.href='index.php?grupo={$id_grupo}';
        });
    </script>";
    exit;
}

/*
|--------------------------------------------------------------------------
| VALIDAR INSCRIPCIÓN ACTIVA
|--------------------------------------------------------------------------
*/
$sqlInscripcion = "
    SELECT
        i.id,
        g.grado,
        g.grupo,
        g.periodo
    FROM inscripciones i
    INNER JOIN grupos g
        ON g.id = i.id_grupo
    WHERE
        i.id_alumno = :id_alumno
        AND i.activo = 1
    LIMIT 1
";

$stmtInscripcion = $conn->prepare($sqlInscripcion);
$stmtInscripcion->bindParam(':id_alumno', $id_alumno);
$stmtInscripcion->execute();

$inscripcion = $stmtInscripcion->fetch(PDO::FETCH_ASSOC);

if ($inscripcion) {

    $grupoActual = $inscripcion['grado'] . "° " .
                   $inscripcion['grupo'] . " (" .
                   $inscripcion['periodo'] . ")";

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Alumno ya inscrito',
            html: 'El alumno ya cuenta con una inscripción activa en:<br><br><strong>{$grupoActual}</strong>'
        }).then(() => {
            window.location.href='index.php?grupo={$id_grupo}';
        });
    </script>";
    exit;
}

/*
|--------------------------------------------------------------------------
| MOSTRAR CONFIRMACIÓN
|--------------------------------------------------------------------------
*/
$nombreCompleto = trim(
    $alumno['primer_apellido'] . ' ' .
    $alumno['segundo_apellido'] . ' ' .
    $alumno['nombre']
);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Confirmar Inscripción</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f8f9fa;
    padding:40px 20px;
}

.card{
    max-width:700px;
    margin:auto;
    border:none;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.card-header{
    background:#1B5E20;
    color:white;
    font-weight:bold;
    text-align:center;
    padding:20px;
}

.label{
    font-weight:bold;
    color:#666;
}

.valor{
    font-size:1.1rem;
    margin-bottom:15px;
}

.btn-confirmar{
    background:#1B5E20;
    color:white;
}

.btn-confirmar:hover{
    background:#144618;
    color:white;
}

</style>

</head>
<body>

<div class="card">

    <div class="card-header">
        CONFIRMAR INSCRIPCIÓN
    </div>

    <div class="card-body">

        <div class="mb-3">
            <div class="label">Número de Control</div>
            <div class="valor"><?= htmlspecialchars($id_alumno); ?></div>
        </div>

        <div class="mb-3">
            <div class="label">Alumno</div>
            <div class="valor"><?= htmlspecialchars($nombreCompleto); ?></div>
        </div>

        <div class="mb-3">
            <div class="label">Grupo</div>
            <div class="valor">
                <?= htmlspecialchars($grupo['grado']); ?>°
                <?= htmlspecialchars($grupo['grupo']); ?>
            </div>
        </div>

        <div class="mb-3">
            <div class="label">Carrera</div>
            <div class="valor">
                <?= htmlspecialchars($grupo['carrera']); ?>
            </div>
        </div>

        <div class="mb-3">
            <div class="label">Periodo</div>
            <div class="valor">
                <?= htmlspecialchars($grupo['periodo']); ?>
            </div>
        </div>

        <form method="POST">

            <input
                type="hidden"
                name="confirmar"
                value="1">

            <input
                type="hidden"
                name="id_grupo"
                value="<?= htmlspecialchars($id_grupo); ?>">

            <input
                type="hidden"
                name="id_alumno"
                value="<?= htmlspecialchars($id_alumno); ?>">

            <div class="d-flex gap-2 justify-content-end">

                <a
                    href="./index.php?grupo=<?= $id_grupo; ?>"
                    class="btn btn-secondary">

                    Cancelar

                </a>

                <button
                    type="submit"
                    class="btn btn-confirmar">

                    Confirmar Inscripción

                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>
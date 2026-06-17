<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('inscripciones');

include './../lib/db.php';

/*
|--------------------------------------------------------------------------
| VALIDAR DATOS RECIBIDOS
|--------------------------------------------------------------------------
*/

$id_grupo = $_POST['id_grupo'] ?? null;

if (
    !$id_grupo ||
    !isset($_FILES['archivo_csv']) ||
    $_FILES['archivo_csv']['error'] != 0
) {
    header("Location: index.php");
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
        c.nombre AS carrera
    FROM grupos g
    INNER JOIN carreras c
        ON c.id = g.id_carrera
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

/*
|--------------------------------------------------------------------------
| LEER CSV
|--------------------------------------------------------------------------
*/

$archivo = fopen(
    $_FILES['archivo_csv']['tmp_name'],
    'r'
);

if (!$archivo) {
    die("No fue posible leer el archivo.");
}

/*
|--------------------------------------------------------------------------
| IGNORAR ENCABEZADO
|--------------------------------------------------------------------------
*/

fgetcsv($archivo);

/*
|--------------------------------------------------------------------------
| VALIDACIONES
|--------------------------------------------------------------------------
*/

$registros = [];
$procesados = [];

$total = 0;
$correctos = 0;
$duplicados = 0;
$noEncontrados = 0;
$yaInscritos = 0;
$formatoIncorrecto = 0;

while (($fila = fgetcsv($archivo)) !== false) {

    if (!isset($fila[0])) {
        continue;
    }

    $numeroControl = trim($fila[0]);

    if ($numeroControl === '') {
        continue;
    }

    $total++;

    $estado = '';
    $nombreAlumno = '';
    $seleccionable = false;

    /*
    |--------------------------------------------------------------------------
    | FORMATO
    |--------------------------------------------------------------------------
    */

    if (!preg_match('/^\d{14}$/', $numeroControl)) {

        $estado = 'Formato inválido';
        $formatoIncorrecto++;

    }
    /*
    |--------------------------------------------------------------------------
    | DUPLICADO EN ARCHIVO
    |--------------------------------------------------------------------------
    */
    elseif (in_array($numeroControl, $procesados)) {

        $estado = 'Duplicado en archivo';
        $duplicados++;

    }
    else {

        $procesados[] = $numeroControl;

        /*
        |--------------------------------------------------------------------------
        | EXISTE ALUMNO
        |--------------------------------------------------------------------------
        */

        $sqlAlumno = "
            SELECT
                id,
                CONCAT(
                    primer_apellido,' ',
                    segundo_apellido,' ',
                    nombre
                ) AS nombre_completo
            FROM alumnos
            WHERE
                id = :id
                AND activo = 1
        ";

        $stmtAlumno = $conn->prepare($sqlAlumno);
        $stmtAlumno->bindParam(':id', $numeroControl);
        $stmtAlumno->execute();

        $alumno = $stmtAlumno->fetch(PDO::FETCH_ASSOC);

        if (!$alumno) {

            $estado = 'Alumno no encontrado';
            $noEncontrados++;

        } else {

            $nombreAlumno = $alumno['nombre_completo'];

            /*
            |--------------------------------------------------------------------------
            | YA INSCRITO
            |--------------------------------------------------------------------------
            */

            $sqlInscripcion = "
                SELECT id
                FROM inscripciones
                WHERE
                    id_alumno = :id_alumno
                    AND activo = 1
            ";

            $stmtInscripcion = $conn->prepare($sqlInscripcion);
            $stmtInscripcion->bindParam(':id_alumno', $numeroControl);
            $stmtInscripcion->execute();

            $inscripcion = $stmtInscripcion->fetch(PDO::FETCH_ASSOC);

            if ($inscripcion) {

                $estado = 'Ya inscrito';
                $yaInscritos++;

            } else {

                $estado = 'Listo para inscribir';
                $correctos++;
                $seleccionable = true;

            }

        }

    }

    $registros[] = [
        'numero_control' => $numeroControl,
        'nombre' => $nombreAlumno,
        'estado' => $estado,
        'seleccionable' => $seleccionable
    ];
}

fclose($archivo);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Validación de Carga Masiva</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f8f9fa;
    padding:30px;
}

.estado-ok{
    color:green;
    font-weight:bold;
}

.estado-error{
    color:red;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

    <h2 class="mb-4">
        Resultado de Validación
    </h2>

    <div class="card mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-2">
                    <strong>Total:</strong><br>
                    <?= $total ?>
                </div>

                <div class="col-md-2">
                    <strong>Correctos:</strong><br>
                    <?= $correctos ?>
                </div>

                <div class="col-md-2">
                    <strong>Duplicados:</strong><br>
                    <?= $duplicados ?>
                </div>

                <div class="col-md-2">
                    <strong>No encontrados:</strong><br>
                    <?= $noEncontrados ?>
                </div>

                <div class="col-md-2">
                    <strong>Ya inscritos:</strong><br>
                    <?= $yaInscritos ?>
                </div>

                <div class="col-md-2">
                    <strong>Formato:</strong><br>
                    <?= $formatoIncorrecto ?>
                </div>

            </div>

        </div>

    </div>

    <form
        action="confirmar_carga.php"
        method="POST">

        <input
            type="hidden"
            name="id_grupo"
            value="<?= $id_grupo ?>">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th width="5%">
                            Sel.
                        </th>

                        <th>
                            Número de Control
                        </th>

                        <th>
                            Alumno
                        </th>

                        <th>
                            Estado
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach($registros as $registro): ?>

                    <tr>

                        <td>

                            <?php if($registro['seleccionable']): ?>

                                <input
                                    type="checkbox"
                                    name="alumnos[]"
                                    value="<?= $registro['numero_control']; ?>"
                                    checked>

                            <?php endif; ?>

                        </td>

                        <td>
                            <?= htmlspecialchars($registro['numero_control']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($registro['nombre']); ?>
                        </td>

                        <td>

                            <?php if($registro['seleccionable']): ?>

                                <span class="estado-ok">
                                    <?= $registro['estado']; ?>
                                </span>

                            <?php else: ?>

                                <span class="estado-error">
                                    <?= $registro['estado']; ?>
                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-between mt-4">

            <a
                href="carga_masiva.php?grupo=<?= $id_grupo ?>"
                class="btn btn-secondary">

                Regresar

            </a>

            <button
                type="submit"
                class="btn btn-success"
                <?= ($correctos == 0) ? 'disabled' : ''; ?>>

                Confirmar Carga

            </button>

        </div>

    </form>

</div>

</body>

</html>
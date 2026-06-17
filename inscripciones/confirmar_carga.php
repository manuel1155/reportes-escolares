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
$alumnos = $_POST['alumnos'] ?? [];

if (
    !$id_grupo ||
    !is_numeric($id_grupo)
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
    SELECT id
    FROM grupos
    WHERE
        id = :id
        AND activo = 1
";

$stmtGrupo = $conn->prepare($sqlGrupo);
$stmtGrupo->bindParam(':id', $id_grupo);
$stmtGrupo->execute();

if (!$stmtGrupo->fetch()) {

    header("Location: index.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| VALIDAR ALUMNOS SELECCIONADOS
|--------------------------------------------------------------------------
*/

if (empty($alumnos)) {

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>

    <script>

    Swal.fire({
        icon: 'warning',
        title: 'Sin alumnos seleccionados',
        text: 'Debe seleccionar al menos un alumno para realizar la carga.'
    }).then(() => {

        window.location.href='carga_masiva.php?grupo={$id_grupo}';

    });

    </script>

    </body>
    </html>
    ";

    exit;

}

/*
|--------------------------------------------------------------------------
| PROCESAR INSCRIPCIONES
|--------------------------------------------------------------------------
*/

$inscritos = 0;
$omitidos = 0;

$conn->beginTransaction();

try {

    foreach ($alumnos as $id_alumno) {

        /*
        |--------------------------------------------------------------------------
        | VALIDAR ALUMNO
        |--------------------------------------------------------------------------
        */

        $sqlAlumno = "
            SELECT id
            FROM alumnos
            WHERE
                id = :id
                AND activo = 1
        ";

        $stmtAlumno = $conn->prepare($sqlAlumno);
        $stmtAlumno->bindParam(':id', $id_alumno);
        $stmtAlumno->execute();

        if (!$stmtAlumno->fetch()) {

            $omitidos++;
            continue;

        }

        /*
        |--------------------------------------------------------------------------
        | VALIDAR QUE NO ESTÉ INSCRITO
        |--------------------------------------------------------------------------
        */

        $sqlExiste = "
            SELECT id
            FROM inscripciones
            WHERE
                id_alumno = :id_alumno
                AND activo = 1
        ";

        $stmtExiste = $conn->prepare($sqlExiste);
        $stmtExiste->bindParam(':id_alumno', $id_alumno);
        $stmtExiste->execute();

        if ($stmtExiste->fetch()) {

            $omitidos++;
            continue;

        }

        /*
        |--------------------------------------------------------------------------
        | INSERTAR INSCRIPCIÓN
        |--------------------------------------------------------------------------
        */

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

        $inscritos++;

    }

    $conn->commit();

} catch (Exception $e) {

    $conn->rollBack();

    var_dump($e);

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>

    <script>

    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Ocurrió un problema al procesar la carga masiva.'
    }).then(() => {

        window.location.href='index.php?grupo={$id_grupo}';

    });

    </script>

    </body>
    </html>
    ";

    exit;

}

/*
|--------------------------------------------------------------------------
| MENSAJE FINAL
|--------------------------------------------------------------------------
*/

$mensaje = "
Inscritos correctamente: {$inscritos}<br>
Omitidos: {$omitidos}
";

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<script>

Swal.fire({
    icon: 'success',
    title: 'Carga Masiva Finalizada',
    html: <?= json_encode($mensaje); ?>,
    confirmButtonText: 'Aceptar'
}).then(() => {

    window.location.href='index.php?grupo=<?= $id_grupo; ?>';

});

</script>

</body>
</html>
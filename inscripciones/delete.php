<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './../lib/permisos.php';
validarPermiso('inscripciones');

include './../lib/db.php';

/*
|--------------------------------------------------------------------------
| VALIDAR PARÁMETROS
|--------------------------------------------------------------------------
*/

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Solicitud inválida',
        text: 'No se recibió una inscripción válida.'
    }).then(() => {
        window.location.href='index.php';
    });
    </script>";
    exit;
}

/*
|--------------------------------------------------------------------------
| OBTENER INFORMACIÓN DE LA INSCRIPCIÓN
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        i.id,
        i.id_grupo,
        a.id AS numero_control,
        CONCAT(
            a.primer_apellido,' ',
            a.segundo_apellido,' ',
            a.nombre
        ) AS alumno
    FROM inscripciones i
    INNER JOIN alumnos a
        ON a.id = i.id_alumno
    WHERE
        i.id = :id
        AND i.activo = 1
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$inscripcion = $stmt->fetch(PDO::FETCH_ASSOC);

echo 'Eliminando ...';

if (!$inscripcion) {

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Registro no encontrado',
        text: 'La inscripción ya fue dada de baja o no existe.'
    }).then(() => {
        window.location.href='index.php';
    });
    </script>";
    exit;
}

/*
|--------------------------------------------------------------------------
| REALIZAR BAJA LÓGICA
|--------------------------------------------------------------------------
*/

try {

    $sqlUpdate = "
        UPDATE inscripciones
        SET activo = 0
        WHERE id = :id
    ";

    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':id', $id);
    $stmtUpdate->execute();

    $id_grupo = $inscripcion['id_grupo'];

    $htmlMensaje = "<b>{$inscripcion['numero_control']}</b><br>{$inscripcion['alumno']}";

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Alumno dado de baja',
        html: " . json_encode($htmlMensaje) . "
    }).then(() => {
        window.location.href='index.php?grupo={$id_grupo}';
    });
    </script>";

} catch (PDOException $e) {

    $id_grupo = $inscripcion['id_grupo'] ?? '';

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No fue posible dar de baja la inscripción.'
    }).then(() => {
        window.location.href='index.php?grupo={$id_grupo}';
    });
    </script>";
}
?>
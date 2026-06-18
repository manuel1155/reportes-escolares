<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('reportes');

include './../lib/db.php';

/*
|--------------------------------------------------------------------------
| VALIDAR PARÁMETROS
|--------------------------------------------------------------------------
*/

$tipo = $_GET['tipo'] ?? '';
$criterio = trim($_GET['criterio'] ?? '');

if (
    empty($tipo)
    || empty($criterio)
    || !in_array($tipo, ['control', 'nombre'])
) {

    header("Location: historial-alumnos.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| CONSULTA
|--------------------------------------------------------------------------
*/

$alumnos = [];

if ($tipo === 'control') {

    $sql = "
        SELECT
            id,
            nombre,
            primer_apellido,
            segundo_apellido
        FROM alumnos
        WHERE
            id = :criterio
            AND activo = 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':criterio', $criterio);

} else {

    $busqueda = "%{$criterio}%";

    $sql = "
        SELECT
            id,
            nombre,
            primer_apellido,
            segundo_apellido
        FROM alumnos
        WHERE
        (
            nombre LIKE :busqueda
            OR primer_apellido LIKE :busqueda
            OR segundo_apellido LIKE :busqueda
        )
        AND activo = 1

        ORDER BY
            primer_apellido,
            segundo_apellido,
            nombre
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':busqueda', $busqueda);
}

$stmt->execute();

$alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalResultados = count($alumnos);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CBTa 159 | Resultados de Búsqueda</title>

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
    max-width:1200px;
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
    padding:8px 15px;
    border-radius:10px;
}

</style>

</head>

<body>

<div class="main-container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>

            <i class="fas fa-users me-2"></i>

            Resultados de Búsqueda

        </h1>

        <a
            href="historial-alumnos.php"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Nueva Búsqueda

        </a>

    </div>

    <div class="card card-info mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <strong>Criterio:</strong><br>

                    <?= htmlspecialchars($criterio); ?>

                </div>

                <div class="col-md-6 text-md-end">

                    <strong>Total Coincidencias:</strong><br>

                    <span class="badge-total">

                        <?= $totalResultados; ?>

                    </span>

                </div>

            </div>

        </div>

    </div>

    <?php if(empty($alumnos)): ?>

        <div class="alert alert-warning">

            No se encontraron alumnos con el criterio indicado.

        </div>

    <?php else: ?>

        <div class="card card-info">

            <div class="card-body">

                <table
                    id="tablaAlumnos"
                    class="table table-hover">

                    <thead>

                        <tr>

                            <th>No. Control</th>
                            <th>Alumno</th>
                            <th>Acción</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($alumnos as $alumno): ?>

                            <tr>

                                <td>

                                    <?= $alumno['id']; ?>

                                </td>

                                <td>

                                    <?= htmlspecialchars(
                                        $alumno['primer_apellido'].' '.
                                        $alumno['segundo_apellido'].' '.
                                        $alumno['nombre']
                                    ); ?>

                                </td>

                                <td width="10%">

                                    <a
                                        href="detalle-historial.php?id=<?= $alumno['id']; ?>"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="fas fa-eye me-1"></i>

                                        Ver Historial

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function(){

    $('#tablaAlumnos').DataTable({

        pageLength: 25,

        order: [[1, 'asc']],

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
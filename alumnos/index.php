<?php
include './../lib/db.php';
$stmt = $conn->prepare("SELECT * FROM alumnos");
$stmt->execute();
$alumnos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Alumnos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Alumnos</h2>

<a href="create.php" class="btn btn-success mb-3">+ Nuevo Alumno</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Matrícula</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            
            
        </tr>
    </thead>
    <tbody>

    <?php foreach($alumnos as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= $a['matricula'] ?></td>
            <td><?= $a['nombre'] ?></td>
            <td><?= $a['apellido_paterno']." ".$a['apellido_materno'] ?></td>
            
            <td>
                <a href="edit.php?id=<?= $a['id'] ?>" class="btn btn-warning btn-sm">Editar</a>

                <a href="delete.php?id=<?= $a['id'] ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirmarEliminacion()">
                   Eliminar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<a href="../" class="btn btn-secondary">Regresar</a>

<!-- SCRIPT DE CONFIRMACIÓN -->
<script>
function confirmarEliminacion() {
    return confirm("¿Estás seguro de eliminar este alumno?");
}
</script>

</body>
</html>
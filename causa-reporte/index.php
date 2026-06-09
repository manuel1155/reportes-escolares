<?php
include './../lib/db.php';
$stmt = $conn->query("SELECT * FROM causas_reporte");
$causas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Causas de Reporte</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Causas de Reporte</h2>

<a href="create.php" class="btn btn-success mb-3">+ Nueva Causa</a>

<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>Descripción</th>
    <th>Puntos</th>
    <th>Acciones</th>
</tr>

<?php foreach($causas as $c): ?>
<tr>
    <td><?= $c['id'] ?></td>
    <td><?= $c['descripcion'] ?></td>
    <td><?= $c['puntos_penalizacion'] ?></td>
    <td>
        <a href="edit.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
        <a href="delete.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('¿Eliminar causa?')">Eliminar</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

<a href="../" class="btn btn-secondary">Regresar</a>

</body>
</html>
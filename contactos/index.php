<?php
include './../lib/db.php';

$sql = "SELECT contactos.*, alumnos.nombre 
        FROM contactos
        LEFT JOIN alumnos ON contactos.alumno_id = alumnos.id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$contactos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Contactos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Contactos</h2>

<a href="create.php" class="btn btn-success mb-3">+ Nuevo Contacto</a>

<table class="table table-bordered">
<thead>
<tr>
    <th>ID</th>
    <th>Alumno</th>
    <th>Nombre Tutor</th>
    <th>Teléfono</th>
    <th>Parentesco</th>
    
</tr>
</thead>

<tbody>
<?php foreach($contactos as $c): ?>
<tr>
    <td><?= $c['id'] ?></td>
    <td><?= $c['nombre'] ?></td>
    <td><?= $c['nombre_tutor'] ?></td>
    <td><?= $c['telefono_tutor'] ?></td>
    <td><?= $c['parentesco'] ?></td>
    <td>
        <a href="edit.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
        <a href="delete.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('¿Eliminar contacto?')">Eliminar</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<a href="../" class="btn btn-secondary">Regresar</a>

</body>
</html>
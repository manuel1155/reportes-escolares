<?php

include './../lib/db.php';

$curp = trim($_GET['curp']);

$stmt = $conn->prepare("
SELECT *
FROM alumnos
WHERE curp=?
");

$stmt->execute([$curp]);

$alumno = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<title>Alumno</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<?php if(!$alumno): ?>

<div class="alert alert-danger">

Alumno no encontrado

</div>

<a href="index.php" class="btn btn-secondary">

Regresar

</a>

<?php else: ?>

<div class="card shadow p-4">

<h3>Alumno Encontrado</h3>

<hr>

<p>

<b>CURP:</b>

<?= $alumno['curp'] ?>

</p>

<p>

<b>Nombre:</b>

<?= $alumno['nombre'] ?>

<?= $alumno['apellido_paterno'] ?>

<?= $alumno['apellido_materno'] ?>

</p>

<a
href="create.php?id=<?= $alumno['id'] ?>"
class="btn btn-danger">

Crear Nuevo Reporte

</a>

<a
href="index.php"
class="btn btn-secondary">

Regresar

</a>

</div>

<?php endif; ?>

</div>

</body>
</html>
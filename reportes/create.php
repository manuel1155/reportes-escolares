<?php

include './../lib/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("
SELECT *
FROM alumnos
WHERE id=?
");

$stmt->execute([$id]);

$alumno = $stmt->fetch();

$causas = $conn->query("
SELECT *
FROM causas_reporte
ORDER BY descripcion
")->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<title>Nuevo Reporte</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow p-4">

<h3 class="text-danger">

Nuevo Reporte Disciplinario

</h3>

<hr>

<p>

<b>Alumno:</b>

<?= $alumno['nombre'] ?>

<?= $alumno['apellido_paterno'] ?>

<?= $alumno['apellido_materno'] ?>

</p>

<p>

<b>CURP:</b>

<?= $alumno['curp'] ?>

</p>

<form action="store.php" method="POST">

<input
type="hidden"
name="alumno_id"
value="<?= $alumno['id'] ?>">

<label>

Causa del Reporte

</label>

<select
name="causa_id"
class="form-control mb-3"
required>

<option value="">

Seleccione...

</option>

<?php foreach($causas as $c): ?>

<option value="<?= $c['id'] ?>">

<?= $c['descripcion'] ?>

(<?= $c['puntos_penalizacion'] ?> puntos)

</option>

<?php endforeach; ?>

</select>

<label>

Comentarios

</label>

<textarea
name="comentarios"
class="form-control mb-3"
rows="5"></textarea>

<button class="btn btn-success">

Guardar Reporte

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

</div>

</body>
</html>
<?php

include './../lib/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("

SELECT

a.id,
a.nombre,
a.primer_apellido,
a.segundo_apellido,

i.id AS id_inscripcion,

g.grado,
g.grupo,

c.nombre AS carrera

FROM alumnos a

INNER JOIN inscripciones i
ON i.id_alumno = a.id

INNER JOIN grupos g
ON g.id = i.id_grupo

INNER JOIN carreras c
ON c.id = g.id_carrera

WHERE a.id = ?
AND a.activo = 1
AND i.activo = 1

LIMIT 1

");

$stmt->execute([$id]);

$alumno = $stmt->fetch();

if(!$alumno){

die("Alumno no encontrado");
}

$causas = $conn->query("

SELECT *
FROM causas
WHERE activo = 1
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

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>Generar Reporte</h3>

</div>

<div class="card-body">

<form action="store.php" method="POST">

<input
type="hidden"
name="id_inscripcion"
value="<?= $alumno['id_inscripcion'] ?>">

<div class="mb-3">

<label>No. Control</label>

<input
class="form-control"
value="<?= $alumno['id'] ?>"
readonly>

</div>

<div class="mb-3">

<label>Alumno</label>

<input
class="form-control"
value="<?= $alumno['nombre'].' '.$alumno['primer_apellido'].' '.$alumno['segundo_apellido'] ?>"
readonly>

</div>

<div class="mb-3">

<label>Carrera</label>

<input
class="form-control"
value="<?= $alumno['carrera'] ?>"
readonly>

</div>

<div class="mb-3">

<label>Grupo</label>

<input
class="form-control"
value="<?= $alumno['grado'].' '.$alumno['grupo'] ?>"
readonly>

</div>

<div class="mb-3">

<label>Causa</label>

<select
name="id_causa"
class="form-select"
required>

<option value="">
Seleccione una causa
</option>

<?php foreach($causas as $c): ?>

<option value="<?= $c['id'] ?>">
<?= $c['descripcion'] ?>
</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Observaciones</label>

<textarea
name="observaciones"
class="form-control"
rows="5"></textarea>

</div>

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

</div>

</body>
</html>
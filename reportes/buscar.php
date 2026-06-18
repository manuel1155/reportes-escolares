<?php

include './../lib/db.php';

$tipo = $_POST['tipo_busqueda'];
$busqueda = trim($_POST['busqueda']);

if($tipo == 'control'){

    $stmt = $conn->prepare("

    SELECT a.*

    FROM alumnos a

    INNER JOIN inscripciones i
    ON i.id_alumno = a.id

    WHERE a.id = ?
    AND a.activo = 1
    AND i.activo = 1

    LIMIT 1

    ");

    $stmt->execute([$busqueda]);

    $alumno = $stmt->fetch();

    if(!$alumno){

        die("
        <h2>No existe el alumno o no tiene inscripción activa.</h2>
        <a href='index.php'>Regresar</a>
        ");

    }

    header("Location:create.php?id=".$alumno['id']);
    exit;
}

$stmt = $conn->prepare("

SELECT DISTINCT a.*

FROM alumnos a

INNER JOIN inscripciones i
ON i.id_alumno = a.id

WHERE CONCAT(
a.nombre,' ',
a.primer_apellido,' ',
a.segundo_apellido
) LIKE ?

AND a.activo = 1
AND i.activo = 1

");

$stmt->execute(["%".$busqueda."%"]);

$resultados = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<title>Coincidencias</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

<h3>Coincidencias encontradas</h3>

<table class="table table-bordered">

<tr>

<th>No. Control</th>
<th>Nombre</th>
<th></th>

</tr>

<?php foreach($resultados as $r): ?>

<tr>

<td><?= $r['id'] ?></td>

<td>
<?= htmlspecialchars(
            $r['nombre'] . ' ' .
            $r['primer_apellido'] . ' ' .
            $r['segundo_apellido']
        ) ?>
</td>

<td>

<a
href="create.php?id=<?= $r['id'] ?>"
class="btn btn-success">

Seleccionar

</a>

</td>

</tr>

<?php endforeach; ?>

</table>

<a href="index.php" class="btn btn-secondary">
Regresar
</a>

</div>

</body>
</html>
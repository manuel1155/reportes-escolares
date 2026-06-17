<?php

include './../lib/db.php';

$id_inscripcion = $_POST['id_inscripcion'];
$id_causa = $_POST['id_causa'];
$observaciones = $_POST['observaciones'];

$stmtUsuario = $conn->query("
SELECT id
FROM usuarios
LIMIT 1
");

$usuario = $stmtUsuario->fetch();

if(!$usuario){
    die("No existe ningún usuario en la tabla usuarios.");
}

$id_usuario = $usuario['id'];

$stmt = $conn->prepare("

INSERT INTO reportes
(
id_inscripcion,
id_causa,
id_usuario,
fecha_hora,
observaciones
)

VALUES
(
?,
?,
?,
NOW(),
?
)

");

$stmt->execute([
$id_inscripcion,
$id_causa,
$id_usuario,
$observaciones
]);

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<title>Reporte Guardado</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="alert alert-success">

<h3>
Reporte generado correctamente
</h3>

</div>

<a
href="index.php"
class="btn btn-success">

Generar otro reporte

</a>

</div>

</body>

</html>
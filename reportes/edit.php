<?php
include './../lib/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM causas_reporte WHERE id=?");
$stmt->execute([$id]);
$c = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Editar Causa</h2>

<form action="update.php" method="POST">

<input type="hidden" name="id" value="<?= $c['id'] ?>">

<input type="text" name="descripcion" value="<?= $c['descripcion'] ?>" class="form-control mb-2">
<input type="number" name="puntos_penalizacion" value="<?= $c['puntos_penalizacion'] ?>" class="form-control mb-2">

<button class="btn btn-primary">Actualizar</button>

</form>

</body>
</html>
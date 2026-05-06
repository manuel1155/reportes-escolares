<?php
include './../lib/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM alumnos WHERE id=?");
$stmt->execute([$id]);
$alumno = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Alumno</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Editar Alumno</h2>

<form action="update.php" method="POST">

    <input type="hidden" name="id" value="<?= $alumno['id'] ?>">

    <input type="text" name="matricula" value="<?= $alumno['matricula'] ?>" class="form-control mb-2">
    <input type="text" name="nombre" value="<?= $alumno['nombre'] ?>" class="form-control mb-2">
    <input type="text" name="apellido_paterno" value="<?= $alumno['apellido_paterno'] ?>" class="form-control mb-2">
    <input type="text" name="apellido_materno" value="<?= $alumno['apellido_materno'] ?>" class="form-control mb-2">
    
    <button class="btn btn-primary">Actualizar</button>
</form>

</body>
</html>
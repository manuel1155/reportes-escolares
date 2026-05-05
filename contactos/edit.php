<?php
include './../lib/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM contactos WHERE id=?");
$stmt->execute([$id]);
$contacto = $stmt->fetch();

$alumnos = $conn->query("SELECT * FROM alumnos")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Contacto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Editar Contacto</h2>

<form action="update.php" method="POST">

<input type="hidden" name="id" value="<?= $contacto['id'] ?>">

<select name="alumno_id" class="form-control mb-2">
<?php foreach($alumnos as $a): ?>
<option value="<?= $a['id'] ?>" 
<?= ($contacto['alumno_id'] == $a['id']) ? 'selected' : '' ?>>
<?= $a['nombre'] ?>
</option>
<?php endforeach; ?>
</select>

<input type="text" name="nombre_tutor" value="<?= $contacto['nombre_tutor'] ?>" class="form-control mb-2">
<input type="text" name="telefono_tutor" value="<?= $contacto['telefono_tutor'] ?>" class="form-control mb-2">
<input type="text" name="parentesco" value="<?= $contacto['parentesco'] ?>" class="form-control mb-3">

<button class="btn btn-primary">Actualizar</button>

</form>

</body>
</html>
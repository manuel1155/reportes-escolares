<?php
include './../lib/db.php';
$alumnos = $conn->query("SELECT * FROM alumnos")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nuevo Contacto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Nuevo Contacto</h2>

<form action="store.php" method="POST">

<select name="alumno_id" class="form-control mb-2" required>
    <option value="">Seleccionar Alumno</option>
    <?php foreach($alumnos as $a): ?>
        <option value="<?= $a['id'] ?>">
            <?= $a['nombre'] ?>
        </option>
    <?php endforeach; ?>
</select>

<input type="text" name="nombre_tutor" class="form-control mb-2" placeholder="Nombre del Tutor" required>

<input type="text" name="telefono_tutor" class="form-control mb-2" placeholder="Teléfono" required>

<input type="text" name="parentesco" class="form-control mb-3" placeholder="Parentesco">

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</div>

</form>

</body>
</html>
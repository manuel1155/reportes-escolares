<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nuevo Alumno</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Nuevo Alumno</h2>

<form action="store.php" method="POST">

    <input type="text" name="matricula" class="form-control mb-2" placeholder="Matrícula" required>

    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>

    <input type="text" name="apellido_paterno" class="form-control mb-2" placeholder="Apellido Paterno" required>

    <input type="text" name="apellido_materno" class="form-control mb-2" placeholder="Apellido Materno">

    
    <!-- BOTONES -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">Guardar</button>

        <a href="index.php" class="btn btn-secondary">
            Cancelar
        </a>
    </div>

</form>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de carreras </title>
</head>
<body>
    <h1>Registro de carreras</h1>

    <form action="store.php" method="post">
        <label for="nombre">Nombre de la carrera:</label>
        <input type="text" id="nombre" name="nombre" required>

        <input type="submit" value="Guardar">
         <a href="./index.php"><input type="button" value="Cancelar"></a>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir tutores</title>
</head>
<body>
    <h1>Añadir tutores</h1>

    <form action="store.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>

        <label for="primer_apellido">primer_apellido:</label>
        <input type="text" id="primer_apellido" name="primer_apellido" required>
        <br>

        <label for="segundo_apellido">segundo_apellido:</label>
        <input type="text" id="segundo_apellido" name="segundo_apellido" required>
        <br>

        <input type="submit" value="Guardar">
         <a href="./index.php"><input type="button" value="Cancelar"></a>
    </form>
</body>
</html>
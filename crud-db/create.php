<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Persona</title>
</head>
<body>
    <h1>Añadir Persona</h1>

    <form action="store.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>
        <br>

        <label for="carnet">Carnet:</label>
        <input type="text" id="carnet" name="carnet" required>
        <br>

        <input type="submit" value="Guardar">
         <a href="./index.php"><input type="button" value="Cancelar"></a>
    </form>
</body>
</html>
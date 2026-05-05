<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir usuarios</title>
</head>
<body>
    <h1>Añadir usuarios</h1>

    <form action="store.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>

        <label for="username">username:</label>
        <input type="text" id="username" name="username" required>
        <br>

        <label for="password">password:</label>
        <input type="text" id="password" name="password" required>
        <br>

      <!-- rol -->
    <label>rol:</label>
    <select name="rol" id="rol" required>
        <option value="">Selecciona tu rol...</option>
        <?php
        $roles = [
            "prefectura",
            "administrador",
            "maestro"
        ];

        foreach ($roles as $r): ?>
            <option value="<?= $r ?>"><?= $r ?></option>
        <?php endforeach; ?>
    </select>
    <br>
     

        <input type="submit" value="Guardar">
         <a href="./index.php"><input type="button" value="Cancelar"></a>
    </form>
</body>
</html>
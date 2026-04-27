<?php
include './../lib/db.php';

$id_usuario = $_GET['id_usuario'];
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute(); 
$usuario = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wid_usuarioth=device-wid_usuarioth, initial-scale=1.0">
    <title>Editar usuarios</title>
</head>
<body>

<h1>Editar usuarios</h1>

<form action="update.php" method="post" onsubmit="return confirmarEdicion()">
    <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

    <label for="nombre">nombre:</label>
    <input type="text" id_usuario="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
    <br>

    <label for="username">username:</label>
    <input type="text" id_usuario="username" name="username" value="<?php echo $usuario['username']; ?>" required>
    <br>

    <label for="password">password:</label>
    <input type="text" id_usuario="password" name="password" value="<?php echo $usuario['password']; ?>" required>
    <br>

     <!-- rol -->
    <label>rol:</label>
    <select name="rol" id="rol" required>
    <?php
    $roles = [
    "prefectura",
    "administrador",
    "maestro"
   ];

    foreach ($roles as $r): ?>
    <option value="<?= $r ?>" <?= ($usuario['rol'] == $r) ? 'selected' : '' ?>>
        <?= $r ?>
    </option>
    <?php endforeach; ?>
    </select>
    <br>
     
     
    <input type="submit" value="Actualizar">
    <a href="./index.php"><input type="button" value="Cancelar"></a>
</form>

<script>
function confirmarEdicion() {
    return confirm("¿Estás seguro de guardar los cambios?");
}
</script>

</body>
</html>
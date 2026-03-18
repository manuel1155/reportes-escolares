<?php
include './../lib/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM personas WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$persona = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Persona</title>
</head>
<body>

<h1>Editar Persona</h1>

<form action="update.php" method="post" onsubmit="return confirmarEdicion()">
    <input type="hidden" name="id" value="<?php echo $persona['id']; ?>">

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $persona['nombre']; ?>" required>
    <br>

    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" value="<?php echo $persona['apellidos']; ?>" required>
    <br>

    <label for="carnet">Carnet:</label>
    <input type="text" id="carnet" name="carnet" value="<?php echo $persona['carnet']; ?>" required>
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
<?php
include './../lib/db.php';

$id = $_GET['id'] ?? null;
$stmt = $conn->prepare("SELECT * FROM carreras WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$carreras = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar carrera</title>
</head>
<body>

<h1>Editar carrera</h1>

<form action="update.php" method="post" onsubmit="return confirmarEdicion()">
    <input type="hidden" name="id" value="<?php echo $carreras['id']; ?>">

    <label>Nombre de la carrera:</label>
    <input type="text" name="nombre" value="<?php echo $carreras['nombre']; ?>">
    <br>

    <input type="submit" value="Actualizar">
    <a href="index.php"><input type="button" value="Cancelar"></a>
</form>

<script>
function confirmarEdicion() {
    return confirm("¿Estás seguro de guardar los cambios?");
}
</script>

</body>
</html>
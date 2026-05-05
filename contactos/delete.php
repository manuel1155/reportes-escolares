<?php
include './../lib/db.php';

$id = $_GET['id'];

$sql = "UPDATE tutores SET activo = 0 WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error al eliminar el registro";
}

header("Location: index.php");
?>
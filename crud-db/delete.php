<?php
include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM personas WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error al eliminar el registro";
}

header("Location: index.php");
?>
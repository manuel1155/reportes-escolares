<?php
include './../lib/db.php';

$id_usuario = $_GET['id_usuario'];

$sql = "UPDATE usuarios SET activo = 0 WHERE id_usuario = :id_usuario";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario);

if ($stmt->execute()) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error al eliminar el registro";
}

header("Location: index.php");
?>
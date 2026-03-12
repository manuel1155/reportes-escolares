<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $carnet = $_POST['carnet'];

    $sql = "UPDATE personas SET nombre = :nombre, apellidos = :apellidos, carnet = :carnet WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':carnet', $carnet);

    if ($stmt->execute()) {
        echo "Registro actualizado exitosamente";
    } else {
        echo "Error al actualizar el registro";
    }

    header("Location: index.php");
}
?>
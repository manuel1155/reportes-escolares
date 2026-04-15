<?php
include './../lib/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO carreras (nombre) VALUES (:nombre)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nombre', $nombre);

    if ($stmt->execute()) {
        echo "Nuevo registro creado exitosamente";
    } else {
        echo "Error al crear el registro";
    }

    header("Location: index.php");
}
?>
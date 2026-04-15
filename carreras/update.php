<?php
include './../lib/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    $sql = "UPDATE carreras SET nombre = :nombre WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $stmt->execute([
        
        ':nombre' => $nombre,
        ':id' => $id
    ]);

    header("Location: index.php");
    exit;
} else {
    echo "Error: no se recibieron datos para actualizar";
}
?>
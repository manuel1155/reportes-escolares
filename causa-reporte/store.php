<?php
include './../lib/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

if (empty($_POST['descripcion'])) {
    die("Selecciona una causa");
}

$stmt = $conn->prepare("INSERT INTO causas (descripcion)
VALUES (?)");

$stmt->execute([
    $_POST['descripcion']
]);

header("Location: index.php");
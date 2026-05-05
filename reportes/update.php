<?php
include './../lib/db.php';

$stmt = $conn->prepare("UPDATE causas_reporte SET descripcion=?, puntos_penalizacion=? WHERE id=?");

$stmt->execute([
    $_POST['descripcion'],
    $_POST['puntos_penalizacion'],
    $_POST['id']
]);

header("Location: index.php");
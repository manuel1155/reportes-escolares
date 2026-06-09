<?php

include './../lib/db.php';

$alumno_id = $_POST['alumno_id'];
$causa_id = $_POST['causa_id'];
$comentarios = $_POST['comentarios'];

$usuario_id = 1;

$stmt = $conn->prepare("
INSERT INTO reportes
(
alumno_id,
causa_id,
usuario_id,
fecha_reporte,
comentarios
)
VALUES
(
?,
?,
?,
NOW(),
?
)
");

$stmt->execute([
    $alumno_id,
    $causa_id,
    $usuario_id,
    $comentarios
]);

header("Location:index.php");
exit;
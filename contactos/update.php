<?php
include './../lib/db.php';

$sql = "UPDATE contactos SET 
        alumno_id=?, 
        nombre_tutor=?, 
        telefono_tutor=?, 
        parentesco=?
        WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $_POST['alumno_id'],
    $_POST['nombre_tutor'],
    $_POST['telefono_tutor'],
    $_POST['parentesco'],
    $_POST['id']
]);

header("Location: index.php");
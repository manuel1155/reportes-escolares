<<?php
include './../lib/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

if (
    empty($_POST['alumno_id']) ||
    empty($_POST['nombre_tutor']) ||
    empty($_POST['telefono_tutor'])
) {
    die("Faltan datos obligatorios");
}

try {
    $sql = "INSERT INTO contactos 
            (alumno_id, nombre_tutor, telefono_tutor, parentesco)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['alumno_id'],
        $_POST['nombre_tutor'],
        $_POST['telefono_tutor'],
        $_POST['parentesco'] ?? null
    ]);

    header("Location: index.php");
    exit;

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
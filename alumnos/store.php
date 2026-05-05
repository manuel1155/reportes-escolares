<?php
include './../lib/db.php';

try {
    // Validar campos obligatorios
    if (empty($_POST['matricula']) || empty($_POST['nombre']) || empty($_POST['apellido_paterno'])) {
        die("Error: Faltan campos obligatorios");
    }

    // Si grupo_id viene vacío, mandar NULL
    $grupo_id = !empty($_POST['grupo_id']) ? $_POST['grupo_id'] : null;

    $sql = "INSERT INTO alumnos 
            (matricula, nombre, apellido_paterno, apellido_materno, grupo_id)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['matricula'],
        $_POST['nombre'],
        $_POST['apellido_paterno'],
        $_POST['apellido_materno'],
        $grupos
    ]);

    // Redirección correcta
    header("Location: index.php");
    exit;

} catch (PDOException $e) {
    echo "Error al guardar: " . $e->getMessage();
}
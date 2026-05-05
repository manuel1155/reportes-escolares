<<?php
include './../lib/db.php';

try {
    // Validar campos obligatorios
    if (empty($_POST['id']) || empty($_POST['matricula']) || empty($_POST['nombre']) || empty($_POST['apellido_paterno'])) {
        die("Faltan datos obligatorios");
    }

    // Validar grupo_id
    $grupo_id = null;

    if (!empty($_POST['grupo_id'])) {
        $check = $conn->prepare("SELECT id FROM grupos WHERE id = ?");
        $check->execute([$_POST['grupo_id']]);

        if ($check->fetch()) {
            $grupo_id = $_POST['grupo_id']; // existe → OK
        }
        // si no existe → queda NULL
    }

    // Actualizar
    $sql = "UPDATE alumnos SET 
            matricula = ?, 
            nombre = ?, 
            apellido_paterno = ?, 
            apellido_materno = ?, 
            grupo_id = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['matricula'],
        $_POST['nombre'],
        $_POST['apellido_paterno'],
        $_POST['apellido_materno'],
        $grupo_id,
        $_POST['id']
    ]);

    header("Location: index.php");
    exit;

} catch (PDOException $e) {
    echo "Error al actualizar: " . $e->getMessage();
}
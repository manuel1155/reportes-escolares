<?php
include './../lib/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grado = $_POST['grado'];
    $grupo = $_POST['grupo'];
    $periodo = $_POST['periodo'];
    $id_carrera = $_POST['id_carrera'];
    $id_tutor = $_POST['id_tutor'];

    $sql = "INSERT INTO grupos (grado, grupo,periodo,id_carrera,id_tutor) VALUES (:grado, :grupo, :periodo, :id_carrera, :id_tutor)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':grado', $grado);
    $stmt->bindParam(':grupo', $grupo);
    $stmt->bindParam(':periodo', $periodo);
    $stmt->bindParam(':id_carrera', $id_carrera);
    $stmt->bindParam(':id_tutor', $id_tutor);
   
   

    if ($stmt->execute()) {
        echo "Nuevo registro creado exitosamente";
    } else {
        echo "Error al crear el registro";
    }

    header("Location: index.php");
}
?>
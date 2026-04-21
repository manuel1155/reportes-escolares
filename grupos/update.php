<?php
include './../lib/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grado = $_POST['grado'];
    $grupo = $_POST['grupo'];
    $periodo = $_POST['periodo'];
    $id_carrera = $_POST['id_carrera'];
    $id_tutor = $_POST['id_tutor'];
   
   

    $sql = "UPDATE grupos SET grado = :grado, grupo =:grupo, periodo = :periodo, id_carrera =:id_carrera, id_tutor =:id_turor WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':grado', $grado);
    $stmt->bindParam(':grupo', $grupo);
    $stmt->bindParam(':periodo', $periodo);
    $stmt->bindParam(':id_carrera', $id_carrera);
    $stmt->bindParam(':id_tutor', $id_tutor);
   
                     
     if ($stmt->execute()) {
        echo "Registro actualizado exitosamente";
    } else {
        echo "Error al actualizar el registro";
    }

    header("Location: index.php");
}
?>
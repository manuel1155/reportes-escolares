<?php
include './../lib/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $grado = $_POST['grado'];
    $grupo = $_POST['grupo'];
    $periodo = $_POST['periodo'];
    $id_carrera = $_POST['id_carrera'];
    $id_tutor = $_POST['id_tutor'];

    // Validar si ya existe otro registro igual
    $sql_validar = "SELECT COUNT(*) AS total
                    FROM grupos
                    WHERE grado = :grado
                    AND grupo = :grupo
                    AND periodo = :periodo
                    AND id_carrera = :id_carrera
                    AND id != :id";

    $stmt_validar = $conn->prepare($sql_validar);

    $stmt_validar->bindParam(':grado', $grado);
    $stmt_validar->bindParam(':grupo', $grupo);
    $stmt_validar->bindParam(':periodo', $periodo);
    $stmt_validar->bindParam(':id_carrera', $id_carrera);
    $stmt_validar->bindParam(':id', $id);

    $stmt_validar->execute();

    $resultado = $stmt_validar->fetch(PDO::FETCH_ASSOC);

    if($resultado['total'] > 0){
        echo "
        <script>
            alert('No se puede actualizar, este registro ya está creado');
            window.location='index.php';
        </script>
        ";
        exit();
    }


    // Update si no hay duplicado
    $sql = "UPDATE grupos 
            SET grado = :grado,
                grupo = :grupo,
                periodo = :periodo,
                id_carrera = :id_carrera,
                id_tutor = :id_tutor
            WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':grado', $grado);
    $stmt->bindParam(':grupo', $grupo);
    $stmt->bindParam(':periodo', $periodo);
    $stmt->bindParam(':id_carrera', $id_carrera);
    $stmt->bindParam(':id_tutor', $id_tutor);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "
        <script>
            alert('Registro actualizado exitosamente');
            window.location='index.php';
        </script>
        ";
    }

}
?>
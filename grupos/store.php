<?php
include './../lib/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $grado = $_POST['grado'];
    $grupo = $_POST['grupo'];
    $periodo = $_POST['periodo'];
    $id_carrera = $_POST['id_carrera'];
    $id_tutor = $_POST['id_tutor'];

    // Validar si el grupo ya existe
    $sql_validar = "SELECT COUNT(*) AS total
                    FROM grupos
                    WHERE grado = :grado
                    AND grupo = :grupo
                    AND id_carrera = :id_carrera
                    AND periodo = :periodo";

    $stmt_validar = $conn->prepare($sql_validar);

    $stmt_validar->bindParam(':grado', $grado);
    $stmt_validar->bindParam(':grupo', $grupo);
    $stmt_validar->bindParam(':id_carrera', $id_carrera);
    $stmt_validar->bindParam(':periodo', $periodo);

    $stmt_validar->execute();

    $resultado = $stmt_validar->fetch(PDO::FETCH_ASSOC);

    if ($resultado['total'] > 0) {
        echo "
            <script>
                alert('El grupo ya existe, no se puede registrar nuevamente');
                window.location='index.php';
            </script>
        ";
        exit();
    }


    // Insertar si no existe
    $sql = "INSERT INTO grupos (grado, grupo, periodo, id_carrera, id_tutor)
            VALUES (:grado, :grupo, :periodo, :id_carrera, :id_tutor)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':grado', $grado);
    $stmt->bindParam(':grupo', $grupo);
    $stmt->bindParam(':periodo', $periodo);
    $stmt->bindParam(':id_carrera', $id_carrera);
    $stmt->bindParam(':id_tutor', $id_tutor);

    if ($stmt->execute()) {
        echo "
            <script>
                alert('Nuevo registro creado exitosamente');
                window.location='index.php';
            </script>
        ";
        exit();
    } else {
        echo "
            <script>
                alert('Error al crear el registro');
                window.location='index.php';
            </script>
        ";
    }

}
?>
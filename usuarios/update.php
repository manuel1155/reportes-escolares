<?php
include './../lib/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios 
            SET nombre = :nombre,
                username = :username,
                password = :password,
                rol = :rol
            WHERE id_usuario = :id_usuario";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':rol', $rol);

    if($stmt->execute()){
        header("Location: index.php");
        exit();
    } else{
        echo "Error al actualizar";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con PHP y MySQL</title>
    
</head>
<body>
    <h1>gestion de usuarios</h1>
    <a href="create.php">registrar usuarios</a>
    <br><br>

    <table border="1">
        <tr>
            <th>id_usuario</th>
            <th>Nombre</th>
            <th>username</th>
            <th>password</th>
            <th>rol</th>
            <th>activo</th>
            <th>Acciones</th>
            </tr>

        <?php
        include './../lib/db.php';

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE activo = 1");
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            echo "<tr>
                    <td>".$row['id_usuario']."</td>
                    <td>".$row['nombre']."</td>
                    <td>".$row['username']."</td>
                    <td>".$row['password']."</td>
                    <td>".$row['rol']."</td>
                    <td>".$row['activo']."</td>
                    <td>
                  <a href='edit.php?id_usuario=".$row['id_usuario']."'>Editar</a>
                  <a href='delete.php?id_usuario=".$row['id_usuario']."' 
                  onclick=\"return confirm('¿Estás seguro que deseas eliminar este registro?');\">
                  Eliminar
                  </a>
                  </td>
                  </tr>";
        }
        ?>
    </table>
    <a href="./..">Regresar</a>
</body>
</html>
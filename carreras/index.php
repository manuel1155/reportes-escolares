<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con PHP y MySQL</title>
    
</head>
<body>
    <h1>carreras</h1>
    <a href="create.php">Añadir registro</a>
    <br><br>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>carrera</th>
            <th>Activo</th>
            <th>Acciones</th>
            
        </tr>
  
        <?php
        include './../lib/db.php';

        $stmt = $conn->prepare("SELECT * FROM carreras WHERE activo = 1");
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['nombre']."</td>
                    <td>".$row['activo']."</td>
                    <td>
                  <a href='edit.php?id=".$row['id']."'>Editar</a>
                  <a href='delete.php?id=".$row['id']."' 
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
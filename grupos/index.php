<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con PHP y MySQL</title>
    
</head>
<body>
    <h1>gestion de grupos</h1>
    <a href="create.php">registrar grupos</a>
    <br><br>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>grado</th>
            <th>grupo</th>
            <th>periodo</th>
            <th>carrera</th>
            <th>tutor</th>
            <th>Acciones</th>
        </tr>

        <?php
        include './../lib/db.php';

        $stmt = $conn->prepare("SELECT g.id, g.grado, g.grupo, g.periodo, g.id_carrera, c.nombre AS nombre_carrera, g.id_tutor, CONCAT(t.nombre,' ',t.primer_apellido,' ',t.segundo_apellido) AS nombre_tutor, g.activo FROM grupos AS g, carreras AS c, tutores AS t WHERE g.activo = 1 AND g.id_carrera = c.id AND g.id_tutor = t.id;");
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['grado']."</td>
                    <td>".$row['grupo']."</td>
                    <td>".$row['periodo']."</td>
                    <td>".$row['nombre_carrera']."</td>
                    <td>".$row['nombre_tutor']."</td>
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
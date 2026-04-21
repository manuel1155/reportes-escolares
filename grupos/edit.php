<?php
include './../lib/db.php';

// Validar ID
if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = $_GET['id'];

// Obtener el grupo a editar
$stmt = $conn->prepare("SELECT * FROM grupos WHERE id = ?");
$stmt->execute([$id]);
$grupo = $stmt->fetch();

if (!$grupo) {
    die("Registro no encontrado");
}

// Carreras
$stmt = $conn->prepare("SELECT * FROM carreras WHERE activo = 1");
$stmt->execute();
$carreras = $stmt->fetchAll();

// Tutores
$stmt = $conn->prepare("SELECT * FROM tutores WHERE activo = 1");
$stmt->execute();
$tutores = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar grupo</title>
</head>
<body>

<h1>Editar grupo</h1>

<form action="update.php" method="post">

    <!-- ID oculto -->
    <input type="hidden" name="id" value="<?= $grupo['id'] ?>">

    <!-- GRADO -->
    <label>Grado:</label>
    <select name="grado" required>
        <option value="">Selecciona el grado...</option>
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <option value="<?= $i ?>" <?= ($grupo['grado'] == $i) ? 'selected' : '' ?>>
                <?= $i ?>
            </option>
        <?php endfor; ?>
    </select>

    <br>

    <!-- GRUPO -->
    <label>Grupo:</label>
    <select name="grupo" required>
        <?php
        $letras = ['A','B','C','D','E','F'];
        foreach ($letras as $letra): ?>
            <option value="<?= $letra ?>" <?= ($grupo['grupo'] == $letra) ? 'selected' : '' ?>>
                <?= $letra ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br>

    <!-- PERIODO -->
    <label>Periodo:</label>
    <select name="periodo" required>
        <?php
        $periodos = [
            "Febrero-2026","Agosto-2026",
            "Febrero-2027","Agosto-2027",
            "Febrero-2028","Agosto-2028"
        ];

        foreach ($periodos as $p): ?>
            <option value="<?= $p ?>" <?= ($grupo['periodo'] == $p) ? 'selected' : '' ?>>
                <?= $p ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br>

    <!-- CARRERA -->
    <label>Carrera:</label>
    <select name="id_carrera" required>
        <option value="">Selecciona una carrera...</option>
        <?php foreach ($carreras as $row): ?>
            <option value="<?= $row['id'] ?>"
                <?= ($grupo['id_carrera'] == $row['id']) ? 'selected' : '' ?>>
                <?= $row['nombre'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br>

    <!-- TUTOR -->
    <label>Tutor:</label>
    <select name="id_tutor" required>
        <option value="">Selecciona un tutor...</option>
        <?php foreach ($tutores as $row): ?>
            <option value="<?= $row['id'] ?>"
                <?= ($grupo['id_tutor'] == $row['id']) ? 'selected' : '' ?>>
                <?= $row['nombre'] . " " . $row['primer_apellido'] . " " . $row['segundo_apellido'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <input type="submit" value="Actualizar">
    <a href="index.php">
        <button type="button">Cancelar</button>
    </a>

</form>

</body>
</html>
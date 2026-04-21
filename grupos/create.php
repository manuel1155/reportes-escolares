<?php
include './../lib/db.php';

$stmt = $conn->prepare("SELECT * FROM carreras WHERE activo = 1");
$stmt->execute();
$carreras = $stmt->fetchAll();

$stmt = $conn->prepare("SELECT * FROM tutores WHERE activo = 1");
$stmt->execute();
$tutores = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de grupos</title>
</head>
<body>

<h1>Añadir grupo</h1>

<form action="store.php" method="post">

    <!-- GRADO -->
    <label for="grado">Grado:</label>
    <select name="grado" id="grado" required>
        <option value="">Selecciona el grado...</option>
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
    </select>

    <br>

    <!-- GRUPO -->
    <label for="grupo">Grupo:</label>
    <select name="grupo" id="grupo" required>
        <option value="">Selecciona el grupo...</option>
        <?php
        foreach (['A','B','C','D','E','F'] as $letra): ?>
            <option value="<?= $letra ?>"><?= $letra ?></option>
        <?php endforeach; ?>
    </select>

    <br>

    <!-- PERIODO -->
    <label for="periodo">Periodo:</label>
    <select name="periodo" id="periodo" required>
        <option value="">Selecciona el periodo...</option>
        <?php
        $periodos = [
            "Febrero-2026","Agosto-2026",
            "Febrero-2027","Agosto-2027",
            "Febrero-2028","Agosto-2028"
        ];

        foreach ($periodos as $p): ?>
            <option value="<?= $p ?>"><?= $p ?></option>
        <?php endforeach; ?>
    </select>

    <br>

    <!-- CARRERA -->
    <label for="id_carrera">Carrera:</label>
    <select name="id_carrera" id="id_carrera" required>
        <option value="">Selecciona una carrera...</option>
        <?php foreach ($carreras as $row): ?>
            <option value="<?= $row['id'] ?>">
                <?= $row['nombre'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br>

    <!-- TUTOR -->
    <label for="id_tutor">Tutor:</label>
    <select name="id_tutor" id="id_tutor" required>
        <option value="">Selecciona un tutor...</option>
        <?php foreach ($tutores as $row): ?>
            <option value="<?= $row['id'] ?>">
                <?= $row['nombre'] . " " . $row['primer_apellido'] . " " . $row['segundo_apellido'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <input type="submit" value="Guardar">
    <a href="index.php">
        <button type="button">Cancelar</button>
    </a>

</form>

</body>
</html>
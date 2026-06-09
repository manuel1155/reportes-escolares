<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nueva Causa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Nueva Causa</h2>

<form action="store.php" method="POST">

<!-- SELECT DE CAUSAS -->
<select id="causa" class="form-control mb-2" required>
    <option value="">Seleccionar causa</option>
    <option value="Bullying" data-puntos="10">Bullying</option>
    <option value="Pelearse entre alumnos" data-puntos="8">Pelearse entre alumnos</option>
    <option value="Discriminación" data-puntos="10">Discriminación</option>
    <option value="Falta de respeto" data-puntos="7">Falta de respeto</option>
    <option value="Sustancias ilícitas" data-puntos="10">Sustancias ilícitas</option>
    <option value="Fumar" data-puntos="6">Fumar</option>
    <option value="No uniforme" data-puntos="3">No cumplir uniforme</option>
    <option value="Manifestaciones físicas" data-puntos="9">Manifestaciones físicas</option>
    <option value="Llegar tarde" data-puntos="2">Llegar tarde</option>
</select>

<!-- CAMPOS OCULTOS -->
<input type="hidden" name="descripcion" id="descripcion">
<input type="hidden" name="puntos_penalizacion" id="puntos">

<div class="d-flex gap-2">
    <button class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</div>

</form>

<script>
document.getElementById('causa').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];
    document.getElementById('descripcion').value = selected.value;
    document.getElementById('puntos').value = selected.getAttribute('data-puntos');
});
</script>

</body>
</html>
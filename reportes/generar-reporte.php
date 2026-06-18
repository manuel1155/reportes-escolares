<?php
date_default_timezone_set('America/Mexico_City');
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>CBTA 159 - Reportes</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.card-header{
background:#198754;
color:white;
}

#reloj{
font-size:30px;
font-weight:bold;
color:#198754;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header">

<h3>CBTA No.159 - Sistema de Reportes</h3>

</div>

<div class="card-body">

<div class="row mb-4">

<div class="col-md-6">

<h5>Fecha:</h5>

<?= date('d/m/Y') ?>

</div>

<div class="col-md-6 text-end">

<div id="reloj"></div>

</div>

</div>

<form action="buscar.php" method="POST">

<div class="mb-3">

<label>Buscar por:</label>

<br>

<input
type="radio"
name="tipo_busqueda"
value="control"
checked>

Número de Control

&nbsp;&nbsp;&nbsp;

<input
type="radio"
name="tipo_busqueda"
value="nombre">

Nombre Completo

</div>

<input
type="text"
name="busqueda"
class="form-control form-control-lg"
required
autofocus>

<br>

 <a
            href="index.php"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left me-2"></i>
            Regresar

        </a>

<button class="btn btn-success">

Buscar Alumno

</button>



</form>

</div>

</div>

</div>

<script>

function actualizarReloj(){

let ahora = new Date();

document.getElementById('reloj').innerHTML =
ahora.toLocaleTimeString();

}

setInterval(actualizarReloj,1000);

actualizarReloj();

</script>

</body>

</html>
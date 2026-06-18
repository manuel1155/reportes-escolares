<?php
session_start();

require_once './../lib/permisos.php';
validarPermiso('reportes');
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CBTa 159 | Historial por Alumno</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

:root{
    --cbta-green:#1B5E20;
    --cbta-gold:#B8860B;
    --bg-light:#f8f9fa;
}

body{
    font-family:'Inter',sans-serif;
    background-color:var(--bg-light);
    padding:40px 20px;
}

.main-container{
    max-width:800px;
    margin:auto;
    background:white;
    padding:35px;
    border-radius:24px;
    box-shadow:0 10px 30px rgba(0,0,0,.03);
    border-top:8px solid var(--cbta-green);
}

h1{
    color:var(--cbta-green);
    font-weight:800;
    text-transform:uppercase;
    font-size:1.5rem;
}

.card-info{
    border:none;
    border-radius:16px;
    box-shadow:0 4px 15px rgba(0,0,0,.04);
}

.btn-cbta{
    background:var(--cbta-green);
    color:white;
    border:none;
}

.btn-cbta:hover{
    background:#144618;
    color:white;
}

.radio-card{
    border:1px solid #dee2e6;
    border-radius:12px;
    padding:15px;
    cursor:pointer;
    transition:.2s;
}

.radio-card:hover{
    border-color:var(--cbta-green);
}

</style>

</head>

<body>

<div class="main-container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>

            <i class="fas fa-user-clock me-2"></i>

            Historial por Alumno

        </h1>

        <a
            href="index.php"
            class="btn btn-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Regresar

        </a>

    </div>

    <div class="card card-info">

        <div class="card-body">

            <form
                action="buscar-alumno.php"
                method="GET"
                id="formBusqueda">

                <div class="mb-4">

                    <label class="form-label fw-bold">

                        Tipo de búsqueda

                    </label>

                    <div class="row">

                        <div class="col-md-6">

                            <label class="radio-card w-100">

                                <input
                                    type="radio"
                                    name="tipo"
                                    value="control"
                                    checked>

                                Número de Control

                            </label>

                        </div>

                        <div class="col-md-6">

                            <label class="radio-card w-100">

                                <input
                                    type="radio"
                                    name="tipo"
                                    value="nombre">

                                Nombre o Apellido

                            </label>

                        </div>

                    </div>

                </div>

                <div class="mb-4">

                    <label
                        class="form-label fw-bold"
                        id="labelBusqueda">

                        Número de Control

                    </label>

                    <input
                        type="text"
                        id="criterio"
                        name="criterio"
                        class="form-control"
                        maxlength="14"
                        minlength="14"
                        pattern="[0-9]{14}"
                        placeholder="Ingrese número de control"
                        required>

                    <small
                        class="text-muted"
                        id="helpBusqueda">

                        Debe contener exactamente 14 dígitos.

                    </small>

                </div>

                <button
                    type="submit"
                    class="btn btn-cbta w-100">

                    <i class="fas fa-search me-2"></i>

                    Buscar Alumno

                </button>

            </form>

        </div>

    </div>

</div>

<script>

const radios = document.querySelectorAll('input[name="tipo"]');
const criterio = document.getElementById('criterio');
const labelBusqueda = document.getElementById('labelBusqueda');
const helpBusqueda = document.getElementById('helpBusqueda');

radios.forEach(radio => {

    radio.addEventListener('change', function(){

        if(this.value === 'control'){

            labelBusqueda.innerText =
                'Número de Control';

            criterio.value = '';

            criterio.setAttribute('maxlength','14');
            criterio.setAttribute('minlength','14');
            criterio.setAttribute('pattern','[0-9]{14}');
            criterio.setAttribute(
                'placeholder',
                'Ingrese número de control'
            );

            helpBusqueda.innerText =
                'Debe contener exactamente 14 dígitos.';

        }else{

            labelBusqueda.innerText =
                'Nombre o Apellido';

            criterio.value = '';

            criterio.removeAttribute('pattern');
            criterio.removeAttribute('minlength');

            criterio.setAttribute('maxlength','100');

            criterio.setAttribute(
                'placeholder',
                'Ingrese nombre o apellido'
            );

            helpBusqueda.innerText =
                'Puede escribir nombre, apellido paterno o apellido materno.';

        }

    });

});

</script>

</body>
</html>
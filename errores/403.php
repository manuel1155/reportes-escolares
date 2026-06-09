<?php
http_response_code(403);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Denegado</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f5f5f5;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            margin:0;
        }

        .contenedor{
            background:white;
            padding:40px;
            border-radius:10px;
            text-align:center;
            box-shadow:0 0 15px rgba(0,0,0,.1);
            max-width:500px;
        }

        h1{
            color:#dc3545;
            font-size:60px;
            margin:0;
        }

        h2{
            margin-top:10px;
            color:#333;
        }

        p{
            color:#666;
            margin:20px 0;
        }

        a{
            display:inline-block;
            padding:10px 20px;
            background:#0d6efd;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }

        a:hover{
            background:#0b5ed7;
        }
    </style>
</head>
<body>

<div class="contenedor">

    <h1>403</h1>

    <h2>Acceso Denegado</h2>

    <p>
        No tienes permisos para acceder a este módulo.
    </p>

    <a href="./../">
        Volver al inicio
    </a>

</div>

</body>
</html>
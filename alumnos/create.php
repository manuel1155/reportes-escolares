<?php
session_start();

require_once './../lib/permisos.php';

validarPermiso('alumnos');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Registro de Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --soft-bg: #f0f2f5;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .student-card {
            background: #ffffff;
            border-radius: 35px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            padding: 3.5rem;
            width: 100%;
            max-width: 700px;
            border-top: 10px solid var(--cbta-green);
            position: relative;
        }

        .student-card::before {
            content: "";
            position: absolute;
            top: 0;
            right: 40px;
            width: 60px;
            height: 10px;
            background: var(--cbta-gold);
            border-radius: 0 0 10px 10px;
        }

        .header-box {
            text-align: center;
            margin-bottom: 3rem;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(27, 94, 32, 0.05);
            color: var(--cbta-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
        }

        h2 {
            font-weight: 800;
            color: #222;
            font-size: 1.6rem;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--cbta-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.8rem;
            color: #555;
            margin-bottom: 8px;
            margin-left: 5px;
        }

        .form-control {
            border-radius: 15px;
            padding: 14px 18px;
            border: 2px solid #f0f0f0;
            background-color: #fcfcfc;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--cbta-green);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(27, 94, 32, 0.05);
        }

        .btn-save {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 18px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            flex: 2;
        }

        .btn-save:hover {
            background-color: #144618;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(27, 94, 32, 0.2);
        }

        .btn-cancel {
            background-color: #f8f9fa;
            color: #999;
            border: 2px solid #eee;
            padding: 16px;
            border-radius: 18px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            transition: 0.3s;
            flex: 1;
        }

        .btn-cancel:hover {
            background-color: #fff;
            color: #dc3545;
            border-color: #ffc9cd;
        }
    </style>
</head>
<body>

<div class="student-card animate__animated animate__fadeIn">
    <div class="header-box">
        <div class="icon-circle">
            <i class="fas fa-user-graduate"></i>
        </div>
        <h2>Nuevo Alumno</h2>
        <p class="text-muted small">Ingresa los datos oficiales para el alta en el sistema.</p>
    </div>

    <form action="store.php" method="POST">
        
        <div class="section-title">Identificación Académica</div>
        
        <div class="mb-4">
            <label class="form-label">Numero de control</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-0 text-muted"><i class="fas fa-id-card"></i></span>
                <input type="text" name="id" class="form-control" placeholder="Ej. 2132405060000" style="border-left: none;" required>
            </div>
        </div>

        
        <div class="mb-4">
            <label class="form-label">curp</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-0 text-muted"><i class="fas fa-id-card"></i></span>
                <input type="text" name="curp" class="form-control" placeholder="Ej. 2132405060000" style="border-left: none;" required>
            </div>
        </div>

        <div class="section-title">Datos Personales</div>

        <div class="mb-3">
            <label class="form-label">Nombre(s)</label>
            <input type="text" name="nombre" class="form-control" placeholder="Nombres del alumno" required>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label">Primer_apellido</label>
                <input type="text" name="primer_apellido" class="form-control" placeholder="Paterno" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">segundo_apellido</label>
                <input type="text" name="segundo_apellido" class="form-control" placeholder="Materno">
            </div>
        </div>

        <div class="d-flex gap-3 mt-5">
            <a href="index.php" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-check-circle me-2"></i>Registrar Alumno
            </button>
        </div>

    </form>
</div>

</body>
</html>
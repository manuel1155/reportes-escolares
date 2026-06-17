<?php
session_start();

require_once './../lib/permisos.php';

validarPermiso('causa-reporte');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Nueva Causa de Reporte</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --soft-bg: #f4f7f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            margin: 0;
        }

        .causa-card {
            background: #ffffff;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            padding: 3.5rem;
            width: 100%;
            max-width: 650px;
            border-top: 10px solid var(--cbta-green);
            position: relative;
        }

        /* Pestaña superior derecha decorativa en Dorado */
        .causa-card::before {
            content: "";
            position: absolute;
            top: 0;
            right: 40px;
            width: 50px;
            height: 10px;
            background: var(--cbta-gold);
            border-radius: 0 0 10px 10px;
        }

        .header-box {
            text-align: center;
            margin-bottom: 2.8rem;
        }

        .icon-circle {
            width: 75px;
            height: 75px;
            background: rgba(27, 94, 32, 0.05);
            color: var(--cbta-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1.2rem;
        }

        h2 {
            font-weight: 800;
            color: #222222;
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            margin: 0;
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
            background: #eeeeee;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.8rem;
            color: #555555;
            margin-bottom: 8px;
            margin-left: 4px;
        }

        .input-group {
            border: 2px solid #f0f0f0;
            border-radius: 15px;
            background-color: #fcfcfc;
            transition: 0.3s;
            overflow: hidden;
        }

        .input-group:focus-within {
            border-color: var(--cbta-green);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(27, 94, 32, 0.05);
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: #a0aec0;
            padding-left: 18px;
            padding-right: 10px;
        }

        .form-control {
            border: none;
            background-color: transparent;
            padding: 14px 18px 14px 5px;
            font-size: 0.95rem;
            color: #2d3748;
        }

        .form-control:focus {
            box-shadow: none;
            background-color: transparent;
        }

        /* Botones integrados con jerarquía visual */
        .btn-save {
            background-color: var(--cbta-green);
            color: #ffffff;
            border: none;
            padding: 15px;
            border-radius: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
            transition: 0.3s;
            flex: 2;
        }

        .btn-save:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(27, 94, 32, 0.18);
        }

        .btn-cancel {
            background-color: #f8f9fa;
            color: #a0aec0;
            border: 2px solid #eeeeee;
            padding: 15px;
            border-radius: 16px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
            transition: 0.3s;
            flex: 1;
        }

        .btn-cancel:hover {
            background-color: #ffffff;
            color: #dc3545;
            border-color: #ffc9cd;
        }
    </style>
</head>
<body>

<div class="causa-card animate__animated animate__fadeInUp">
    <div class="header-box">
        <div class="icon-circle">
            <i class="fas fa-gavel"></i>
        </div>
        <h2>Nueva Causa</h2>
        <p class="text-muted small mb-0">Define un nuevo criterio normativo o conductual para el plantel.</p>
    </div>

    <form action="store.php" method="POST">
        
        <div class="section-title">Parámetros del Criterio</div>
        
        <div class="mb-4">
            <label for="descripcion" class="form-label">Descripción de la falta</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ej. Retardo injustificado a primera hora" required>
            </div>
        </div>

        <!-- BOTONES DE ACCIÓN -->
        <div class="d-flex gap-3 mt-5">
            <a href="index.php" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-floppy-disk me-2"></i>Guardar Causa
            </button>
        </div>

    </form>
</div>

<!-- Mantenemos el bloque del script opcional limpio por si llegas a integrar los selectores interactivos -->
<script>
    const causaSelect = document.getElementById('causa');
    if (causaSelect) {
        causaSelect.addEventListener('change', function() {
            let selected = this.options[this.selectedIndex];
            document.getElementById('descripcion').value = selected.value;
            document.getElementById('puntos').value = selected.getAttribute('data-puntos');
        });
    }
</script>

</body>
</html>
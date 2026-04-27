<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Añadir Tutores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --bg-light: #F4F7F6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .form-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.06);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            border-top: 8px solid var(--cbta-green);
        }

        .icon-header {
            width: 80px;
            height: 80px;
            background: rgba(27, 94, 32, 0.05);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--cbta-green);
            font-size: 2.2rem;
            transform: rotate(-5deg);
        }

        h1 {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--cbta-green);
            text-align: center;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        p.subtitle {
            text-align: center;
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 2.5rem;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: var(--cbta-green);
            border-radius: 12px 0 0 12px !important;
        }

        .form-control {
            border-left: none;
            padding: 12px;
            border-radius: 0 12px 12px 0 !important;
            font-size: 1rem;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
            background-color: #fff;
        }

        .btn-save {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 15px;
            font-weight: 700;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-save:hover {
            background-color: #144618;
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(27, 94, 32, 0.2);
            color: white;
        }

        .btn-cancel {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #adb5bd;
            font-size: 0.85rem;
            margin-top: 1.5rem;
            transition: 0.3s;
            font-weight: 600;
        }

        .btn-cancel:hover {
            color: var(--cbta-gold);
        }
    </style>
</head>
<body>

<div class="form-card animate__animated animate__zoomIn">
    <div class="icon-header">
        <i class="fas fa-user-tie"></i>
    </div>
    
    <h1>Nuevo Tutor</h1>
    <p class="subtitle">Complete la información del tutor institucional.</p>

    <form action="store.php" method="post">
        
        <div>
            <label for="nombre" class="form-label">Nombre(s)</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo" required>
            </div>
        </div>

        <div>
            <label for="primer_apellido" class="form-label">Primer Apellido</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" placeholder="Apellido paterno" required>
            </div>
        </div>

        <div>
            <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" placeholder="Apellido materno" required>
            </div>
        </div>

        <button type="submit" class="btn btn-save">
            <i class="fas fa-check-circle me-2"></i> Registrar Tutor
        </button>

        <a href="./index.php" class="btn-cancel">
            <i class="fas fa-arrow-left me-1"></i> Volver al listado
        </a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
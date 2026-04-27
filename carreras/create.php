<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Registro de Carreras</title>
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
            color: #333;
        }

        .form-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            border-top: 6px solid var(--cbta-green);
        }

        .icon-header {
            width: 70px;
            height: 70px;
            background: rgba(27, 94, 32, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--cbta-green);
            font-size: 1.8rem;
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--cbta-green);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        p.subtitle {
            text-align: center;
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: var(--cbta-green);
        }

        .form-control {
            border-left: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
            background-color: #fcfdfc;
        }

        .btn-save {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-save:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.2);
            color: white;
        }

        .btn-cancel {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #aaa;
            font-size: 0.9rem;
            margin-top: 1.5rem;
            transition: 0.3s;
            font-weight: 500;
        }

        .btn-cancel:hover {
            color: var(--cbta-gold);
        }
    </style>
</head>
<body>

<div class="form-card animate__animated animate__fadeInUp">
    <div class="icon-header">
        <i class="fas fa-book"></i>
    </div>
    
    <h1>Registro de Carreras</h1>
    <p class="subtitle">Ingrese el nombre de la nueva oferta académica.</p>

    <form action="store.php" method="post">
        <div class="mb-4">
            <label for="nombre" class="form-label">Nombre de la carrera</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                <input type="text" class="col form-control" id="nombre" name="nombre" placeholder="Ej: Técnico en Ofimática" required>
            </div>
        </div>

        <button type="submit" class="btn btn-save">
            <i class="fas fa-save me-2"></i> Guardar Carrera
        </button>

        <a href="./index.php" class="btn-cancel">
            <i class="fas fa-times me-1"></i> Cancelar registro
        </a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Nuevo Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            padding: 3rem;
            width: 100%;
            max-width: 480px;
            border-top: 6px solid var(--cbta-green);
        }

        .header-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header-section i {
            color: var(--cbta-gold);
            margin-bottom: 1rem;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--cbta-green);
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 0.5rem;
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
            font-size: 0.95rem;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
            background-color: #fdfdfd;
        }

        .btn-save {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.2);
            color: white;
        }

        .btn-cancel {
            background: transparent;
            border: 1px solid #ddd;
            color: #888;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: 0.3s;
        }

        .btn-cancel:hover {
            background-color: #f8d7da;
            border-color: #f5c2c7;
            color: #842029;
        }

        .footer-note {
            text-align: center;
            font-size: 0.75rem;
            color: #bbb;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

    <div class="form-card">
        <div class="header-section">
            <i class="fas fa-user-plus fa-3x"></i>
            <h1>Añadir Persona</h1>
            <p class="text-muted small">CBTa 159 - Sistema de Registro</p>
        </div>
        
        <form action="store.php" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos paterno y materno" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="carnet" class="form-label">Carnet de Identidad</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    <input type="text" class="form-control" id="carnet" name="carnet" placeholder="Número de identificación" required>
                </div>
            </div>

            <div class="d-grid gap-3">
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save me-2"></i> Guardar Registro
                </button>
                <a href="./index.php" class="btn btn-cancel">
                    <i class="fas fa-times me-2"></i> Cancelar
                </a>
            </div>
        </form>

        <div class="footer-note">
            Propiedad Institucional • CBTa 159
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
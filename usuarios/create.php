<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --soft-bg: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-bg);
            background-image: radial-gradient(#d1d1d1 0.8px, transparent 0.8px);
            background-size: 30px 30px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .user-card {
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            border-top: 8px solid var(--cbta-green);
        }

        .header-icon {
            width: 70px;
            height: 70px;
            background-color: rgba(27, 94, 32, 0.05);
            color: var(--cbta-green);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
        }

        h1 {
            font-weight: 800;
            color: var(--cbta-green);
            font-size: 1.6rem;
            text-align: center;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: var(--cbta-gold);
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border-left: none;
            padding: 11px;
            background-color: #fcfcfc;
            font-size: 0.95rem;
            border-radius: 0 12px 12px 0 !important;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 4px rgba(27, 94, 32, 0.08);
            border-color: #dee2e6;
        }

        /* Botones Sutiles */
        .btn-submit {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 14px;
            font-weight: 700;
            width: 100%;
            margin-top: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(27, 94, 32, 0.15);
        }

        .btn-back {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #adb5bd;
            font-weight: 600;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .btn-back:hover {
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="user-card animate__animated animate__fadeInUp">
    <div class="header-icon">
        <i class="fas fa-user-plus"></i>
    </div>
    
    <h1>Nuevo Usuario</h1>

    <form action="store.php" method="post">
        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                <input type="text" class="form-control" name="nombre" placeholder="Ej. Juan Pérez" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre de Usuario</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-at"></i></span>
                <input type="text" class="form-control" name="username" placeholder="usuario123" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="••••••••" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Rol de Sistema</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-shield-halved"></i></span>
                <select name="rol" class="form-select" required>
                    <option value="" selected disabled>Seleccionar rol...</option>
                    <?php
                    $roles = ["prefectura", "administrador", "maestro"];
                    foreach ($roles as $r): ?>
                        <option value="<?= $r ?>"><?= ucfirst($r) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-save me-2"></i>Crear Usuario
        </button>

        <a href="./index.php" class="btn-back">
            <i class="fas fa-times me-1"></i> Cancelar registro
        </a>
    </form>
</div>

</body>
</html>
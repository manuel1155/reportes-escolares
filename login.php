<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Control de Accesos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --bg-gradient: linear-gradient(135deg, #f4f7f6 0%, #e9ecef 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .login-card {
            background: #ffffff;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.06);
            padding: 3rem 2.5rem 2.5rem;
            width: 100%;
            max-width: 440px;
            border-top: 8px solid var(--cbta-green);
            position: relative;
        }

        .login-card::before {
            content: "";
            position: absolute;
            top: 0;
            right: 35px;
            width: 50px;
            height: 8px;
            background: var(--cbta-gold);
            border-radius: 0 0 8px 8px;
        }

        /* Contenedor armónico para la imagen */
        .brand-header {
            text-align: center;
            margin-bottom: 2.2rem;
        }

        .logo-container {
            max-width: 110px; /* Tamaño ideal para mantener la proporción */
            height: auto;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-container img {
            width: 100%;
            height: auto;
            object-fit: contain;
            /* Filtro opcional por si deseas darle una elevación sutil a la imagen */
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.04)); 
        }

        h2 {
            font-weight: 800;
            color: #222222;
            font-size: 1.35rem;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .subtitle {
            color: #8c98a5;
            font-size: 0.85rem;
            margin-top: 6px;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            color: #555555;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: block;
        }

        .input-group {
            border: 2px solid #f0f0f0;
            border-radius: 14px;
            background-color: #fcfcfc;
            transition: 0.3s;
            overflow: hidden;
        }

        .input-group:focus-within {
            border-color: var(--cbta-green);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(27, 94, 32, 0.04);
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
        }

        .btn-login {
            background-color: var(--cbta-green);
            color: #ffffff;
            border: none;
            padding: 15px;
            border-radius: 14px;
            font-weight: 700;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            transition: 0.3s;
            margin-top: 1.2rem;
        }

        .btn-login:hover {
            background-color: #144618;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(27, 94, 32, 0.15);
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.75rem;
            color: #a0aec0;
        }
    </style>
</head>
<body>

<div class="login-card animate__animated animate__fadeInUp">
    <div class="brand-header">
        <div class="logo-container">
            <img src="./lib/img/logo-cbta.png" alt="Logo CBTa 159">
        </div>
        <h2>SGE CBTa 159</h2>
        <div class="subtitle">Sistema de Gestión de Reportes Escolares</div>
    </div>

    <form method="POST" action="./sesion/validar.php">
        
        <div class="mb-3">
            <label class="form-label">Correo Institucional</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="usuario@cbta159.edu.mx" required autocomplete="email">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="fas fa-right-to-bracket me-2"></i>Iniciar Sesión
        </button>
    </form>

    <div class="footer-text">
        &copy; 2026 CBTa 159 &bull; Todos los derechos reservados.
    </div>
</div>

</body>
</html>
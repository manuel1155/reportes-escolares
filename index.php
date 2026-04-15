<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Sistema de Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --soft-bg: #fdfdfd;
            --text-main: #2c3e50;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            /* Sutil patrón de puntos profesional */
            background-image: radial-gradient(#d1d1d1 0.8px, transparent 0.8px);
            background-size: 25px 25px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            margin: 0;
        }

        .main-card {
            background: #ffffff;
            border-radius: 24px;
            border: none;
            padding: 4rem 3rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
            text-align: center;
            max-width: 550px;
            border-bottom: 6px solid var(--cbta-gold);
            position: relative;
        }

        /* Línea de acento superior */
        .main-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background-color: var(--cbta-green);
            border-radius: 24px 24px 0 0;
        }

        .icon-container {
            width: 90px;
            height: 90px;
            background-color: rgba(27, 94, 32, 0.05);
            color: var(--cbta-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 2rem;
        }

        h1 {
            font-weight: 800;
            color: var(--cbta-green);
            font-size: 2.2rem;
            margin-bottom: 1.2rem;
            letter-spacing: -1px;
        }

        p.description {
            color: #6c757d;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 3rem;
        }

        .btn-cbta {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .btn-cbta:hover {
            background-color: #144618;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(27, 94, 32, 0.15);
        }

        .footer-info {
            margin-top: 3.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }

        .footer-info small {
            color: #adb5bd;
            font-weight: 600;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center">
        <div class="main-card">
            <div class="icon-container">
                <i class="fas fa-graduation-cap"></i>
            </div>
            
            <h1>Reportes Escolares</h1>
            
            <p class="description">
                Plataforma oficial de gestión y control de datos académicos. 
                Diseñada para la eficiencia y transparencia de nuestra comunidad educativa.
            </p>
            
            <a href="./crud-db" class="btn-cbta">
                <i class="fas fa-database"></i> Acceder al Sistema
            </a>
            
            <div class="footer-info">
                <small>CBTA NO. 159 • MODO INSTITUCIONAL</small>
            </div>
        </div>
    </div>
</body>
</html>
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
            --text-main: #2c3e50;
            --soft-green: rgba(27, 94, 32, 0.06);
            --hover-green: rgba(27, 94, 32, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            background-image: radial-gradient(#d1d1d1 0.8px, transparent 0.8px);
            background-size: 25px 25px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .main-card {
            background: #ffffff;
            border-radius: 30px;
            padding: 3.5rem 2.5rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.06);
            text-align: center;
            max-width: 600px;
            width: 90%;
            border-top: 8px solid var(--cbta-green);
            border-bottom: 8px solid var(--cbta-gold);
        }

        .icon-container {
            width: 80px;
            height: 80px;
            background-color: var(--soft-green);
            color: var(--cbta-green);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1.5rem;
        }

        h1 {
            font-weight: 800;
            color: var(--cbta-green);
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .description {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 2.5rem;
        }

        /* --- SECCIÓN DE BOTONES ESTÉTICOS --- */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 15px;
            margin-bottom: 1rem;
        }

        .btn-module {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
            background-color: var(--soft-green);
            color: var(--cbta-green);
            border: 1.5px solid transparent;
            border-radius: 18px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-module i {
            font-size: 1.5rem;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }

        .btn-module span {
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Efectos Hover */
        .btn-module:hover {
            background-color: white;
            border-color: var(--cbta-gold);
            color: var(--cbta-gold);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(184, 134, 11, 0.1);
        }

        .btn-module:hover i {
            transform: scale(1.2);
        }

        .footer-info {
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f1f1;
        }

        .footer-info small {
            color: #adb5bd;
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

    <div class="main-card">
        <div class="icon-container">
            <i class="fas fa-layer-group"></i>
        </div>
        
        <h1>Panel de Gestión</h1>
        <p class="description">Seleccione el módulo que desea administrar para continuar.</p>
        
        <div class="menu-grid">
            <a href="./crud-db" class="btn-module">
                <i class="fas fa-user-graduate"></i>
                <span>Personas</span>
            </a>

            <a href="./carreras" class="btn-module">
                <i class="fas fa-book"></i>
                <span>Carreras</span>
            </a>

            <a href="./tutores" class="btn-module">
                <i class="fas fa-user-tie"></i>
                <span>Tutores</span>
            </a>

            <a href="./tutores" class="btn-module">
                <i class="fas fa-user-tie"></i>
                <span>Reportes</span>
            </a>

            <a href="./tutores" class="btn-module">
                <i class="fas fa-user-tie"></i>
                <span>Grupos</span>
            </a>

        </div>
        
        <div class="footer-info">
            <small>CBTA NO. 159 • SISTEMA CENTRAL</small>
        </div>
    </div>

</body>
</html>
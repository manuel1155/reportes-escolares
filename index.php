<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ./login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Sistema Central</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --cbta-green: #1B5E20;
            --cbta-gold: #B8860B;
            --sidebar-width: 280px;
            --header-height: 100px; /* Incrementado un poco para lucir mejor los logos */
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden; 
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
        }

        /* --- BARRA SUPERIOR (MEMBRETE) --- */
        .top-header {
            height: var(--header-height);
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            border-bottom: 4px solid var(--cbta-gold);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            position: relative;
        }

        .header-logo {
            height: 80px; /* Ajuste para que los logos se vean claros */
            width: auto;
            object-fit: contain;
        }

        .header-title {
            text-align: center;
            flex-grow: 1;
        }

        .header-title h1 {
            font-weight: 800;
            color: var(--cbta-green);
            margin: 0;
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* --- CONTENEDOR PRINCIPAL --- */
        .wrapper {
            display: flex;
            height: calc(100vh - var(--header-height));
            width: 100vw;
        }

        /* --- BARRA LATERAL --- */
        .sidebar {
            width: var(--sidebar-width);
            background: #ffffff;
            border-right: 1px solid rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            z-index: 100;
            padding: 1.5rem;
        }

        .sidebar-brand {
            text-align: center;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid rgba(27, 94, 32, 0.05);
            margin-bottom: 2rem;
        }

        /* --- APARTADO DE BOTONES CON PROPORCIÓN FIJA Y SCROLL --- */
        .nav-list {
            height: 70%;              /* Ajuste fijo al 70% del espacio disponible */
            overflow-y: auto;         /* Despliegue de barra lateral si se desborda */
            padding-right: 5px;       /* Pequeño espacio para que el scroll no encime los botones */
        }

        /* Personalización estética de la barra de scroll (Opcional) */
        .nav-list::-webkit-scrollbar {
            width: 6px;
        }
        .nav-list::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.03);
            border-radius: 10px;
        }
        .nav-list::-webkit-scrollbar-thumb {
            background: rgba(27, 94, 32, 0.2);
            border-radius: 10px;
        }
        .nav-list::-webkit-scrollbar-thumb:hover {
            background: var(--cbta-green);
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 8px;
            color: #444;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            border: 1px solid transparent;
        }

        .nav-link-custom i {
            width: 30px;
            font-size: 1.2rem;
            color: var(--cbta-green);
        }

        .nav-link-custom:hover {
            background: rgba(27, 94, 32, 0.05);
            color: var(--cbta-green);
            transform: translateX(5px);
        }

        .nav-link-custom:focus {
            background: var(--cbta-green);
            color: white !important;
        }
        .nav-link-custom:focus i { color: white; }

        /* --- VISOR DE CONTENIDO --- */
        .content-viewer {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background: #f4f7f6;
            position: relative;
        }

        #main-frame {
            width: 100%;
            height: 100%;
            border: none;
            background: transparent;
        }
    </style>
</head>
<body>

    <header class="top-header">
        <img src="./lib/img/logo-cbta.png" alt="Escudo Institucional CBTa 159" class="header-logo">
        
        <div class="header-title">
            <h1>SISTEMA DE REPORTES</h1>
        </div>

        <img src="./lib/img/logo-gorilas.png" alt="Logo Gorilas" class="header-logo">
    </header>

    <div class="wrapper">
        <nav class="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-layer-group fa-2x" style="color: var(--cbta-green);"></i>
                <div class="fw-bold mt-2" style="color: var(--cbta-green);">GESTIÓN CBTa 159</div>
            </div>

            <div class="nav-list">
                <a href="inicio_dashboard.html" target="visor" class="nav-link-custom">
                    <i class="fas fa-home"></i> <span>Inicio</span>
                </a>
                            
                <?php if (in_array('personas', $_SESSION['permisos'])): ?>
                    <a href="./crud-db/" target="visor" class="nav-link-custom">
                        <i class="fas fa-user-graduate"></i> <span>CRUD Ejemplo</span>
                    </a>
                <?php endif; ?>


                <?php if (in_array('carreras', $_SESSION['permisos'])): ?>
                    <a href="./carreras/" target="visor" class="nav-link-custom">
                        <i class="fas fa-book"></i> <span>Carreras</span>
                    </a>
                <?php endif; ?>
                 

                <?php if (in_array('causas', $_SESSION['permisos'])): ?>
                    <a href="./causa-reporte/" target="visor" class="nav-link-custom">
                    <i class="fas fa-user-tie"></i> <span>Causas</span>
                </a>
                <?php endif; ?>


                <?php if (in_array('tutores', $_SESSION['permisos'])): ?>
                    <a href="./tutores/" target="visor" class="nav-link-custom">
                    <i class="fas fa-user-tie"></i> <span>Tutores</span>
                </a>
                <?php endif; ?>


                <?php if (in_array('grupos', $_SESSION['permisos'])): ?>
                   <a href="./grupos/" target="visor" class="nav-link-custom">
                      <i class="fas fa-user-shield"></i> <span>Grupos</span>
                      </a>
                <?php endif; ?>
                
               <?php if (in_array('usuarios', $_SESSION['permisos'])): ?>
                    <a href="./usuarios/" target="visor" class="nav-link-custom">
                    <i class="fas fa-user-shield"></i> <span>Usuarios</span>
                   </a>
              <?php endif; ?>

              <?php if (in_array('alumnos', $_SESSION['permisos'])): ?>
                <a href="./alumnos/" target="visor" class="nav-link-custom">
                    <i class="fas fa-user-shield"></i> <span>Alumnos</span>
                    </a>
            <?php endif; ?>

            <?php if (in_array('contactos', $_SESSION['permisos'])): ?>
                <a href="./contactos/" target="visor" class="nav-link-custom">
                    <i class="fas fa-user-shield"></i> <span>Contactos</span>
                   </a>
            <?php endif; ?>

            <?php if (in_array('reportes', $_SESSION['permisos'])): ?>
                <a href="./reportes/" target="visor" class="nav-link-custom">
                    <i class="fas fa-user-shield"></i> <span>Reportes</span>
                </a>
            <?php endif; ?>

            <?php if (in_array('inscripciones', $_SESSION['permisos'])): ?>
                <a href="./inscripciones/" target="visor" class="nav-link-custom">
                    <i class="fas fa-clipboard"></i> <span>Inscripciones</span>
                </a>
            <?php endif; ?>
                <a href="./sesion/logout.php" class="nav-link-custom">
                    <i class="fas fa-sign-out"></i> <span>Salir</span>
            </a>
            
                
            </div>
        </nav>

        <main class="content-viewer">
            <iframe name="visor" id="main-frame" src="inicio_dashboard.html"></iframe>
        </main>
    </div>

</body>
</html>
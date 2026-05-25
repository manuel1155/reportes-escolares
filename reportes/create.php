<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBTa 159 | Nueva Causa de Penalización</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .causa-card {
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            border-left: 8px solid #dc3545; /* Rojo para indicar penalización/advertencia */
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(220, 53, 69, 0.05);
            color: #dc3545;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        h2 {
            font-weight: 800;
            color: #333;
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        p.subtitle {
            color: #777;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            color: var(--cbta-green);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-select {
            border-radius: 12px;
            padding: 12px;
            border: 2px solid #eee;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .form-select:focus {
            border-color: var(--cbta-green);
            box-shadow: none;
        }

        /* Puntos Display */
        #puntos-display {
            background: #fdf2f2;
            color: #dc3545;
            padding: 10px 15px;
            border-radius: 10px;
            font-weight: 800;
            display: none; /* Se muestra al seleccionar */
            text-align: center;
            margin-bottom: 1.5rem;
            border: 1px dashed #dc3545;
        }

        .btn-save {
            background-color: var(--cbta-green);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 700;
            transition: 0.3s;
            flex: 1;
        }

        .btn-save:hover {
            background-color: #144618;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background-color: #eee;
            color: #666;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 700;
            text-align: center;
            transition: 0.3s;
            flex: 1;
        }

        .btn-cancel:hover {
            background-color: #e2e2e2;
            color: #333;
        }
    </style>
</head>
<body>

<div class="causa-card animate__animated animate__fadeInDown">
    <div class="header-icon">
        <i class="fas fa-triangle-exclamation"></i>
    </div>
    
    <h2>Nueva Causa</h2>
    <p class="subtitle">Selecciona la incidencia para aplicar penalización.</p>

    <form action="store.php" method="POST">
        <div class="mb-3">
            <label for="causa" class="form-label">Tipo de Incidencia</label>
            <select id="causa" class="form-select" name="causa_select" required>
                <option value="" disabled selected>Seleccionar causa...</option>
                <option value="Bullying" data-puntos="10">Bullying</option>
                <option value="Pelearse entre alumnos" data-puntos="8">Pelearse entre alumnos</option>
                <option value="Discriminación" data-puntos="10">Discriminación</option>
                <option value="Falta de respeto" data-puntos="7">Falta de respeto</option>
                <option value="Sustancias ilícitas" data-puntos="10">Sustancias ilícitas</option>
                <option value="Fumar" data-puntos="6">Fumar</option>
                <option value="No uniforme" data-puntos="3">No cumplir uniforme</option>
                <option value="Manifestaciones físicas" data-puntos="9">Manifestaciones físicas</option>
                <option value="Llegar tarde" data-puntos="2">Llegar tarde</option>
            </select>
        </div>

        <div id="puntos-display" class="animate__animated animate__pulse">
            Penalización: <span id="puntos-val">0</span> puntos
        </div>

        <input type="hidden" name="descripcion" id="descripcion">
        <input type="hidden" name="puntos_penalizacion" id="puntos">

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-save">
                <i class="fas fa-check me-2"></i>Guardar
            </button>
            <a href="index.php" class="btn btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<script>
document.getElementById('causa').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];
    let descripcion = selected.value;
    let puntos = selected.getAttribute('data-puntos');

    // Actualizar campos ocultos
    document.getElementById('descripcion').value = descripcion;
    document.getElementById('puntos').value = puntos;

    // Actualizar visor visual
    const display = document.getElementById('puntos-display');
    const valSpan = document.getElementById('puntos-val');
    
    valSpan.innerText = puntos;
    display.style.display = 'block';
    
    // Reiniciar animación del visor
    display.classList.remove('animate__pulse');
    void display.offsetWidth; // Trigger reflow
    display.classList.add('animate__pulse');
});
</script>

</body>
</html>
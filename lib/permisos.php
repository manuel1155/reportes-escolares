<?php

function validarPermiso($permiso)
{
    // Verificar que exista una sesión activa
    if (!isset($_SESSION['email'])) {
        header("Location: /errores/403.php");
        exit;
    }

    // Verificar permisos
    if (
        !isset($_SESSION['permisos']) ||
        !in_array($permiso, $_SESSION['permisos'])
    ) {
        header("Location: ./../errores/403.php");
        exit;
    }
}
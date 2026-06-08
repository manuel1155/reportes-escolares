<?php
session_start();

// Conexión a la base de datos
include './../lib/db.php';

// Datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta a la base de datos
$sql = "SELECT * FROM usuarios WHERE email = :email AND password = :password AND activo = 1;";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->execute();

// Obtener resultado
$datos = $stmt->fetch(PDO::FETCH_ASSOC);
   
// Validar si encontró el email
if (!empty($datos)) {

    // Datos básicos de sesión
    $_SESSION['email'] = $datos['email'];

    // Construir arreglo de permisos
    $permisos = [];

    foreach ($datos as $campo => $valor) {

        // Ignorar campos que no son permisos
        if (in_array($campo, ['email', 'password','id','activo'])) {
            continue;
        }

        if ($valor == 1) {
            $permisos[] = $campo;
        }
    }

    $_SESSION['permisos'] = $permisos;

    header("Location: ./../index.php");
    exit;
} else {

    echo "❌ Usuario o contraseña incorrectos";
    echo '<a href="./../login.php" class="btn btn-secondary">Regresar</a>';

}
?>   
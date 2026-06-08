<?php
$servername = "192.168.1.20";
$port = "3306";
$email = "SisRepCBTa159";
$password = "Js54h1Smq3S8";
$dbname = "control_escolar";

try {
    $conn = new PDO(
        "mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8",
        $email,
        $password
    );

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
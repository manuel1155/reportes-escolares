<?php
include './../lib/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM causas_reporte WHERE id=?");
$stmt->execute([$id]);

header("Location: index.php");
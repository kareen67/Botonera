<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("../controller/conexionBD.php");

if (!isset($_SESSION["id_usuario"])) {
    echo json_encode(["error" => "No logueado"]);
    exit;
}

$id_usuario = $_SESSION["id_usuario"];
$sql = "SELECT id_fx, nombre, clasificacion_fx, ruta_archivo FROM fx WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$fxs = [];
while ($row = $result->fetch_assoc()) {
    $fxs[] = $row;
}

echo json_encode($fxs);
?>

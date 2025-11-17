<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("../controller/conexionBD.php");

// FX institucionales: sin usuario y sin programa asignado
$sql = "SELECT id_fx, nombre, clasificacion_fx, ruta_archivo 
        FROM fx 
        WHERE id_usuario IS NULL AND id_programa IS NULL";
$result = $Ruta->query($sql);

$fxs = [];
while ($row = $result->fetch_assoc()) {
    $fxs[] = $row;
}

echo json_encode($fxs);
?>

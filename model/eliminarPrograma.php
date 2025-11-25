<?php
session_start();

// Validar que sea el jefe de operadores
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "jefe") {
    header("Location: ../login.php");
    exit();
}

include_once("../controller/conexionBD.php");

if (!isset($_POST["id_programa"])) {
    header("Location: ../view/pages/jefe/panel-admin.php");
    exit();
}

$id_programa = intval($_POST["id_programa"]);

// Eliminar asignaciones de operadores
$Ruta->query("DELETE FROM operador_programa WHERE id_programa = '$id_programa'");

// Eliminar asignaciones de productores
$Ruta->query("DELETE FROM productor_programa WHERE id_programa = '$id_programa'");

// Eliminar FX asociados
$Ruta->query("DELETE FROM fx WHERE id_programa = '$id_programa'");

// Finalmente eliminar el programa
$Ruta->query("DELETE FROM programa_radial WHERE id_programa = '$id_programa'");

// Redireccionar con éxito
header("Location: ../view/pages/jefe/panel-admin.php?mensaje=programa_eliminado");
exit();

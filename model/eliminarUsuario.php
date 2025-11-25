<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'jefe') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_POST["id_usuario"])) {
    header("Location: ../view/pages/jefe/panel-admin.php");
    exit();
}

include_once("../controller/conexionBD.php");

$idUsuario = intval($_POST["id_usuario"]);

// 🔒 Evitar que el admin se elimine a sí mismo
if ($idUsuario == $_SESSION["id_usuario"]) {
    echo "<script>alert('❌ No puedes eliminar tu propio usuario.'); window.location.href='../view/pages/jefe/panel-admin.php';</script>";
    exit();
}

// 🔹 Eliminación del usuario
$query = "DELETE FROM usuario WHERE id_usuario = ?";
$stmt = $Ruta->prepare($query);
$stmt->bind_param("i", $idUsuario);

if ($stmt->execute()) {
    echo "<script>alert('Usuario eliminado correctamente ✔'); window.location.href='../view/pages/jefe/panel-admin.php';</script>";
} else {
    echo "<script>alert('❌ Error al eliminar usuario'); window.location.href='../view/pages/jefe/panel-admin.php';</script>";
}

<?php
session_start();

include_once("../controller/conexionBD.php"); // Cambiar según tu ruta y nombre

// Verificar que el usuario esté logueado
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../view/pages/login.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cambiar_password"])) {

    $password_actual = $_POST["password_actual"];
    $password_nueva = $_POST["password_nueva"];
    $password_confirmar = $_POST["password_confirmar"];

    // Validar coincidencia de nueva contraseña
    if ($password_nueva !== $password_confirmar) {
        echo "<script>alert('❌ Las nuevas contraseñas no coinciden'); history.back();</script>";
        exit();
    }

    // Obtener la contraseña actual desde la DB
    $stmt = $Ruta->prepare("SELECT password FROM usuario WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($password_hash);
    $stmt->fetch();

    if ($stmt->num_rows === 0) {
        echo "<script>alert('❌ Usuario no encontrado'); history.back();</script>";
        exit();
    }

    // Verificar que la contraseña actual sea correcta
    if (!password_verify($password_actual, $password_hash)) {
        echo "<script>alert('❌ La contraseña actual es incorrecta'); history.back();</script>";
        exit();
    }

    $stmt->close();

    // Encriptar nueva contraseña
    $password_nueva_hash = password_hash($password_nueva, PASSWORD_DEFAULT);

    // Actualizar contraseña
    $stmt = $Ruta->prepare("UPDATE usuario SET password = ? WHERE id_usuario = ?");
    $stmt->bind_param("si", $password_nueva_hash, $id_usuario);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Contraseña actualizada correctamente'); window.location.href='../view/pages/Perfil.php';</script>";
    } else {
        echo "<script>alert('❌ Error al actualizar la contraseña'); history.back();</script>";
    }

    $stmt->close();
}
?>

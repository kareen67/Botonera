<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../controller/conexionBD.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verificamos que el usuario esté logueado
    if (!isset($_SESSION["id_usuario"])) {
        echo "<script> alert('Debes iniciar sesión para subir FX'); window.location.href='../view/login.php';</script>";
        exit();
    }

    $id_usuario = $_SESSION["id_usuario"];
    $nombre = trim($_POST["nombre"]);
    $clasificacion = trim($_POST["clasificacion"]);

    // Validamos los datos
    if (empty($nombre) || empty($clasificacion) || empty($_FILES["archivo"]["name"])) {
        echo "<script>window.location.href='../view/pages/operador/fx-reproducir.php'; alert('Todos los campos son obligatorios'); history.back();</script>";
        exit();
    }

    // Configuración de subida
    $carpetaDestino = "../uploads/fx/";
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    $nombreArchivo = basename($_FILES["archivo"]["name"]);
    $rutaDestino = $carpetaDestino . $nombreArchivo;
    $rutaEnBD = "uploads/fx/" . $nombreArchivo; // ruta relativa que se guardará en la BD

    // Mover archivo
    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaDestino)) {

        // Insertar en la base de datos
        $stmt = $Ruta->prepare("INSERT INTO fx (ruta_archivo, clasificacion_fx, nombre, id_usuario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $rutaEnBD, $clasificacion, $nombre, $id_usuario);

        if ($stmt->execute()) {
            echo "<script>alert('✅ FX guardado correctamente'); window.location.href='../view/pages/operador/fx-reproducir.php';</script>";
        } else {
            echo "<script>window.location.href='../view/pages/operador/fx-reproducir.php'; alert('❌ Error al guardar FX: " . $stmt->error . "'); history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>window.location.href='../view/pages/operador/fx-reproducir.php'; alert('Error al subir el archivo'); history.back();</script>";
    }
}
?>

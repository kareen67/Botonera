<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../controller/conexionBD.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar datos
    if (empty($_POST["nombre"]) || empty($_POST["clasificacion"]) || empty($_FILES["archivo"]["name"])) {
        echo "<script>alert('⚠️ Todos los campos son obligatorios'); history.back();</script>";
        exit();
    }

    $nombre = trim($_POST["nombre"]);
    $clasificacion = trim($_POST["clasificacion"]);

    // Configuración de subida de archivos
    $carpetaDestino = "../uploads/fx/";
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    $nombreArchivo = basename($_FILES["archivo"]["name"]);
    $rutaDestino = $carpetaDestino . $nombreArchivo;
    $rutaEnBD = "uploads/fx/" . $nombreArchivo;

    // Subir el archivo
    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaDestino)) {

        // Guardar en BD SIN usuario y SIN programa
        $stmt = $Ruta->prepare("INSERT INTO fx (ruta_archivo, clasificacion_fx, nombre, id_programa, id_usuario) 
                                VALUES (?, ?, ?, NULL, NULL)");
        $stmt->bind_param("sss", $rutaEnBD, $clasificacion, $nombre);

        if ($stmt->execute()) {
            echo "<script>alert('🎵 FX institucional registrado correctamente'); window.location.href='../view/pages/jefe/fx-institucional.html';</script>";
        } else {
            echo "<script>alert('❌ Error al guardar FX: " . $stmt->error . "'); history.back();</script>";
        }

        $stmt->close();

    } else {
        echo "<script>alert('❌ Error al subir el archivo'); history.back();</script>";
    }
}
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../controller/conexionBD.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recibir datos
    $id_programa = intval($_POST["id_programa"]);
    $nombre = trim($_POST["nombre"]);
    $clasificacion = trim($_POST["clasificacion"]);

    // Validación básica
    if (empty($nombre) || empty($clasificacion) || empty($_FILES["archivo"]["name"]) || $id_programa <= 0) {
        echo "<script>alert('⚠ Todos los campos son obligatorios'); history.back();</script>";
        exit();
    }

    // Carpeta destino
    $carpetaDestino = "../uploads/fx/";
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    // Archivo
    $nombreArchivo = time() . "_" . basename($_FILES["archivo"]["name"]);
    $rutaDestino = $carpetaDestino . $nombreArchivo;
    $rutaEnBD = "uploads/fx/" . $nombreArchivo; // Ruta relativa para la BD

    // Subida del archivo
    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaDestino)) {

        // Insertar en BD (id_usuario = NULL)
        $stmt = $Ruta->prepare("INSERT INTO fx (ruta_archivo, clasificacion_fx, nombre, id_programa, id_usuario)
                                VALUES (?, ?, ?, ?, NULL)");
        $stmt->bind_param("sssi", $rutaEnBD, $clasificacion, $nombre, $id_programa);

        if ($stmt->execute()) {
            echo "<script>alert('🎧 FX agregado correctamente'); 
                  window.location.href='../view/pages/operador/detalle-op.php?id_programa=$id_programa';
                  </script>";
        } else {
            echo "<script>alert('❌ Error en la BD: {$stmt->error}'); history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('❌ Error al subir el archivo'); history.back();</script>";
    }
}
?>

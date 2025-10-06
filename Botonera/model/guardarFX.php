<?php
session_start();
require_once __DIR__ . '/../controller/conexionBD.php'; // conexión

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    $usuarioId = $_SESSION['id_usuario']; // id del usuario logueado
    $nombreFx = $_POST['nombre'];
    $clasificacion = $_POST['clasificacion'];

    // rutas
    $nombreArchivo = basename($_FILES["archivo"]["name"]);
    $rutaRelativa = "uploads/" . $nombreArchivo;         // se guarda en la BD
    $rutaAbsoluta = __DIR__ . '/../' . $rutaRelativa;    // ubicación real

    // mover el archivo subido
    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaAbsoluta)) {
        $sql = "INSERT INTO FX (ruta_archivo, clasificacion_fx, nombre, id_usuario) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $rutaRelativa, $clasificacion, $nombreFx, $usuarioId);
        $stmt->execute();

        echo "Archivo subido y guardado en la BD correctamente.";
    } else {
        echo "Error al subir el archivo.";
    }
}
?>

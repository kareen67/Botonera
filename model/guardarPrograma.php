<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../controller/conexionBD.php"); // Ajustado a tu estructura

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["crear_programa"])) {

    // Validar campos requeridos
    if (!empty($_POST["nombre"]) && !empty($_POST["horario"]) && !empty($_POST["descripcion"])) {

        $nombre = trim($_POST["nombre"]);
        $horario = trim($_POST["horario"]);
        $descripcion = trim($_POST["descripcion"]);

        // Verificar si ya existe un programa con el mismo nombre
        $stmt = $Ruta->prepare("SELECT id_programa FROM programa_radial WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script> window.location.href='../../view/pages/jefe/Panel-admin.php'; alert('❌ Ya existe un programa con ese nombre');</script>";
        } else {
            // Insertar el nuevo programa
            $stmt = $Ruta->prepare("INSERT INTO programa_radial (nombre, horario, descripcion) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $horario, $descripcion);

            if ($stmt->execute()) {
                echo "<script>window.location.href='../../view/pages/jefe/Panel-admin.php'; alert('✅ Programa creado correctamente');</script>";
            } else {
                echo "<script>window.location.href='../../view/pages/jefe/Panel-admin.php'; alert('❌ Error al crear programa: " . $stmt->error . "');</script>";
            }
        }

        $stmt->close();
    } else {
        echo "<script>window.location.href='../../view/pages/jefe/Panel-admin.php'; alert('Todos los campos son obligatorios');</script>";
    }
}
?>

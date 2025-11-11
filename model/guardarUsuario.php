<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../controller/conexionBD.php"); // Ajusta si tu archivo de conexión tiene otro nombre o ubicación

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["crear_usuario"])) {

    if (!empty($_POST["nombre"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["rol"])) {

        $nombre = trim($_POST["nombre"]);
        $email = trim($_POST["email"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $rol = strtolower(trim($_POST["rol"]));

        // Normalizar valor del select al ENUM de tu tabla
        switch ($rol) {
            case 'operador':
                $rol = 'operador';
                break;
            case 'productor':
                $rol = 'productor';
                break;
            case 'jefe':
                $rol = 'jefe';
                break;
            default:
                echo "<script>window.location.href='../view/pages/jefe/Panel-admin.php'; alert('Rol no válido');</script>";
                exit();
        }

        // Verificar si el correo ya existe
        $stmt = $Ruta->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>window.location.href='../view/pages/jefe/Panel-admin.php'; alert('El correo ya está registrado');</script>";
        } else {
            // Insertar usuario nuevo
            $stmt = $Ruta->prepare("INSERT INTO usuario (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nombre, $email, $password, $rol);

            if ($stmt->execute()) {
                echo "<script>window.location.href='../view/pages/jefe/Panel-admin.php'; alert('✅ Usuario creado correctamente');</script>";
            } else {
                echo "<script>window.location.href='../view/pages/jefe/Panel-admin.php'; alert('❌ Error al crear usuario: " . $stmt->error . "');</script>";
            }
        }

        $stmt->close();
    } else {
        echo "<script>window.location.href='../view/pages/jefe/Panel-admin.php'; alert('Todos los campos son obligatorios');</script>";
    }
}
?>

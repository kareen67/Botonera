<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_POST["ingresar"])) { 
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Consulta preparada
        $stmt = $Ruta->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($usuario = $resultado->fetch_object()) {
            // Verifica la contraseña ingresada contra la hasheada
            if (password_verify($password, $usuario->password)) {
                $_SESSION["usuario"] = $usuario->email;
                header("Location: ../../index.html");
                exit();
            } else {
                echo 'Error en Usuario y/o Contraseña';
            }
        } else {
            echo 'Error en Usuario y/o Contraseña';
        }
    } else {
        echo 'Todos los campos son obligatorios';
    }
}
?>


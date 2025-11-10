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
            // Verifica la contraseña
            if (password_verify($password, $usuario->password)) {
                // Guarda los datos en sesión
                $_SESSION["usuario"] = $usuario->email;
                $_SESSION["rol"] = $usuario->rol; // <-- asegurate que tu tabla tenga este campo
                $_SESSION["id_usuario"] = $usuario->id_usuario; 

                // Redirección según rol
                switch ($usuario->rol) {
                    case 'jefe':
                        header("Location: ../view/pages/jefe/Panel-admin.php");
                        break;
                    case 'operador':
                        header("Location: ../view/pages/operador/fx-reproducir.php");
                        break;
                    case 'productor':
                        header("Location: ../view/pages/productor/panel-productor.html");
                        break;
                    default:
                        // Si el rol no coincide con ninguno
                        header("Location: ../index.html");
                        break;
                }
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


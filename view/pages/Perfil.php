<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

include_once("../../controller/conexionBD.php");

$id_usuario = $_SESSION["id_usuario"]; // debe guardarse al iniciar sesión

$sql = "SELECT nombre, email, rol FROM usuario WHERE id_usuario = ?";
$stmt = $Ruta->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$datosUsuario = $result->fetch_assoc();

$nombre = $datosUsuario['nombre'];
$email = $datosUsuario['email'];
$rol = $datosUsuario['rol'];


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil-Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/Perfil.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/fondo-musical.css">
</head>

<body>
    <!-- Mini Top Bar -->
    <div class="mini-topbar">
        <div class="socials">
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
            <span class="contact">+54 9 11 1234-5678</span>
        </div>
        <p class="phrase">Conectando cada programa con su mejor sonido!!</p>
    </div>

    <!-- Header principal -->
    <header class="topbar">
        <div class="logo">
            <img src="../img/SonarBo.png" alt="SonarBo">
            <h1>SonarBo</h1>
        </div>

        <nav class="nav-links">
            <?php if ($_SESSION["rol"] === "jefe"): ?>
                <a href="Panel-admin.php">Administración</a>
                <a href="fx-institucionales.php">FX</a>

            <?php elseif ($_SESSION["rol"] === "operador"): ?>
                <a href="panel-operador.php">Mis Programas</a>
                <a href="fx-reproducir.php">FX</a>

            <?php elseif ($_SESSION["rol"] === "productor"): ?>
                <a href="panel-productor.php">Mis Programas</a>
                <a href="vs-fx.php">FX</a>

            <?php else: ?>
                <a href="../../index.php">Inicio</a>
            <?php endif; ?>
        </nav>

        <div class="user-section">
            <a href="Perfil.php" class="profile-icon">
                <i class="fa-solid fa-user"></i>
            </a>
            <a href="../../model/logout.php" class="exit-btn">Exit</a>

        </div>
    </header>
    <div class="musical-background">
        <span>♪</span>
        <span>♫</span>
        <span>♬</span>
        <span>♩</span>
        <span>♭</span>
        <span>♮</span>
        <span>♯</span>
        <span>♬</span>
        <span>♪</span>
        <span>♩</span>
        <span>♫</span>
        <span>♭</span>
    </div>
    <section class="perfil-container">
        <!-- Información Personal -->
        <div class="card info-personal">
            <h2><i class="fa-solid fa-user"></i> Información Personal</h2>
            <p class="subtitulo">Detalles de tu cuenta en el sistema</p>

            <div class="usuario">
                <div class="avatar">
                    <i class="fa-solid fa-user-circle"></i>
                </div>
                <div>
                    <h3><?php echo $nombre; ?></h3>
                    <p><?php echo $email; ?></p>
                </div>
            </div>

            <div class="campo">
                <span class="label"><i class="fa-regular fa-envelope"></i> Email</span>
                <p class="valor"><?php echo $email; ?></p>
            </div>

            <div class="campo">
                <span class="label"><i class="fa-solid fa-key"></i> Rol</span>
                <p class="valor">
                    Administrador del sistema con acceso completo
                    <span class="rol-tag"><?php echo ucfirst($rol); ?></span>
                </p>
            </div>
        </div>

        <!-- Cambiar Contraseña -->
        <div class="card cambiar-pass">
            <h2><i class="fa-solid fa-lock"></i> Cambiar Contraseña</h2>
            <p class="subtitulo">Actualiza tu contraseña para mantener tu cuenta segura</p>

            <form action="../../model/cambiarPassword.php" method="POST">
                <label>Contraseña Actual</label>
                <input name="password_actual" type="password" placeholder="Ingresa tu contraseña actual" required>

                <label>Nueva Contraseña</label>
                <input name="password_nueva" type="password" placeholder="Ingresa tu nueva contraseña" required>

                <label>Confirmar Nueva Contraseña</label>
                <input name="password_confirmar" type="password" placeholder="Confirma tu nueva contraseña" required>

                <button type="submit" name="cambiar_password">Actualizar Contraseña</button>
            </form>

            <div class="consejos">
                <h4>Consejos de Seguridad</h4>
                <ul>
                    <li>Usa al menos 8 caracteres</li>
                    <li>Incluye mayúsculas y minúsculas</li>
                    <li>Agrega números y símbolos</li>
                    <li>No uses información personal</li>
                </ul>
            </div>
        </div>
    </section>

</body>

</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION["rol"] ?? "visitante";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Sonoro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            <?php if ($rol === "jefe"): ?>
                <a href="../pages/jefe/Panel-admin.php">Administración</a>
                <a href="../pages/jefe/programas.php">Mis Programas</a>
                <a href="../pages/jefe/fx.php">FX</a>

            <?php elseif ($rol === "operador"): ?>
                <a href="../pages/operador/panel-operador.php">Mis Programas</a>
                <a href="../pages/operador/fx.php">FX</a>

            <?php elseif ($rol === "productor"): ?>
                <a href="../pages/productor/panel-productor.php">Mis Programas</a>
                <a href="../pages/productor/fx.php">FX</a>

            <?php else: ?>
                <a href="../index.php">Inicio</a>
            <?php endif; ?>
        </nav>

        <div class="user-section">
            <a href="../pages/Perfil.html" class="profile-icon">
                <i class="fa-solid fa-user"></i>
            </a>

            <form action="../backend/logout.php" method="POST">
                <button class="exit-btn">Exit</button>
            </form>
        </div>
    </header>
</body>
</html>

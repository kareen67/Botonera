<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "productor") {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efectos de Sonido (FX) personales y institucionales, puede agregar propios y reproducir institucionales
    </title>
    <link rel="stylesheet" href="../../css/vs-fx.css">
    <link rel="stylesheet" href="../../css/barra-reproducir.css">
    <!-- <link rel="stylesheet" href="../../css/fx-institucionales.css"> -->
    <link rel="stylesheet" href="../../css/detalle-fx-op.css">
    <link rel="stylesheet" href="../../css/opciones.css">
    <link rel="stylesheet" href="../../css/modal-agregar.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/fondo-musical.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            <img src="../../img/SonarBo.png" alt="SonarBo">
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
            <a href="../Perfil.php" class="profile-icon">
                <i class="fa-solid fa-user"></i>
            </a>
            <a href="../../../model/logout.php" class="exit-btn">Exit</a>

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

    <main class="contenido">
      
        <div class="descripcion">
            <h2><i class="fa-solid fa-volume-high"></i> Efectos de Sonido (FX)</h2>
            <p class="subtexto">Reproduce la biblioteca institucional</p>
        </div>
        <section class="fx-section">
            <div class="fx-header">
                <h3><i class="fa-solid fa-music"></i> Biblioteca de FX</h3>
            </div>
            <!-- Tabs -->
            <div class="tabs">
                <button class="tab" data-target="institucionales"><i class="fa-solid fa-building"></i> FX
                    Institucionales</button>
            </div>
            <!-- FX INSTITUCIONALES  -->
            <div id="institucionales" class="fx-inst">
                <div class="fx-item">
                    <span class="fx-etiqueta">Intro</span>
                    <div class="fx-info">
                        <h4>Inicio Programa</h4>
                        <div class="fx-meta">
                            <span class="duracion"><i class="fa-regular fa-clock"></i> 0:15</span>
                        </div>
                    </div>
                    <button class="play"><i class="fa-solid fa-play"></i></button>

                </div>
                <div class="fx-item">
                    <span class="fx-etiqueta">Intro</span>
                    <div class="fx-info">
                        <h4>Inicio Programa</h4>
                        <div class="fx-meta">
                            <span class="duracion"><i class="fa-regular fa-clock"></i> 0:15</span>
                        </div>
                    </div>
                    <button class="play"><i class="fa-solid fa-play"></i></button>
                </div>

            </div>

        </section>

    </main>
    <script src="../../js/player.js"></script>
    <script src="../../js/barra-reproduccion.js"></script>
    <script src="../../js/reproducir.js"></script>

    <script src="../../js/opciones.js"></script>
    <script src="../../js/modal-tabs.js"></script>

</body>

</html>
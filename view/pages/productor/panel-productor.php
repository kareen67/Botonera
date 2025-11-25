<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "productor") {
    header("Location: ../../login.php");
    exit();
}
    // Header dinámico
include "../../layouts/header.php";
?> 

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Programas Asignados</title>
    <link rel="stylesheet" href="../../css/panel-operador.css" />
    <link rel="stylesheet" href="../../css/fondo-musical.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
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
    <section class="programas">
        <div class="container">
            <div class="titulo">
                <h1><i class="fa-solid fa-microphone-lines"></i> Programas Producidos</h1>
                <p class="subtitulo">Revisa tus programas que produces</p>
            </div>

            <div class="tarjetas">
                <?php
                    include_once("../../../controller/conexionBD.php");

                    // ID del productor logueado
                    $idUsuario = $_SESSION["id_usuario"];

                    // Consulta de los programas asignados al productor
                    $query = "SELECT p.* 
                            FROM programa_radial p
                            INNER JOIN productor_programa pp ON p.id_programa = pp.id_programa
                            WHERE pp.id_usuario = '$idUsuario'";

                    $result = $Ruta->query($query);

                    if ($result && $result->num_rows > 0):
                        while ($programa = $result->fetch_assoc()):
                ?>

                <div class="tarjeta">
                    <div class="header-tarjeta">
                        <h2><?= htmlspecialchars($programa['nombre']) ?></h2>
                        <span class="rol">
                            <i class="fa-solid fa-user-gear"></i> Productor
                        </span>
                    </div>

                    <p class="descripcion">
                        <?= htmlspecialchars($programa['descripcion']) ?>
                    </p>

                    <div class="info">
                        <p>
                            <i class="fa-regular fa-clock"></i>
                            <?= htmlspecialchars($programa['horario']) ?>
                        </p>
                        <p>
                            <i class="fa-solid fa-headphones"></i>
                            Producción General
                        </p>
                    </div>

                    <!-- Enlace a detalles del programa -->
                    <form action="detalle-pr.php" method="GET">
                        <input type="hidden" name="id_programa" value="<?= $programa['id_programa']; ?>">
                        <button class="btn">Ver Detalles →</button>
                    </form>
                </div>

                <?php 
                    endwhile;
                else:
                ?>
                    <p>No tienes programas asignados actualmente.</p>
                <?php endif; ?>
            </div>

        </div>
    </section>

</body>

</html>
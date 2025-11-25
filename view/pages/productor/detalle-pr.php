<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "productor") {
    header("Location: ../../../login.php");
    exit();
}
    // Header dinámico
include "../../layouts/header.php";

include_once("../../../controller/conexionBD.php");

if (!isset($_GET['id_programa'])) {
    header("Location: panel-productor.php");
    exit();
}

$idPrograma = intval($_GET['id_programa']);

$query = "SELECT p.*, 
        (SELECT nombre FROM usuario u 
         INNER JOIN productor_programa pp ON u.id_usuario = pp.id_usuario 
         WHERE pp.id_programa = p.id_programa LIMIT 1) AS productor,
        (SELECT nombre FROM usuario u 
         INNER JOIN operador_programa op ON u.id_usuario = op.id_usuario 
         WHERE op.id_programa = p.id_programa LIMIT 1) AS operador
        FROM programa_radial p
        WHERE p.id_programa = ?";

$stmt = $Ruta->prepare($query);
$stmt->bind_param("i", $idPrograma);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $programa = $result->fetch_assoc();
} else {
    echo "Programa no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Programa - Productor</title>

    <link rel="stylesheet" href="../../css/detalle-fx-op.css">
    <link rel="stylesheet" href="../../css/opciones.css">
    <link rel="stylesheet" href="../../css/modal-agregar.css">
    <link rel="stylesheet" href="../../css/fondo-musical.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/barra-reproducir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="musical-background"></div>

<main class="contenido">

    <a href="panel-productor.php" class="volver">
        <i class="fa-solid fa-arrow-left"></i> Volver a Programas
    </a>

    <!-- SECCIÓN DEL PROGRAMA -->
    <section class="programa">
        <div class="info-programa">
            <h2><?= htmlspecialchars($programa['nombre']); ?></h2>
            <p class="descripcion"><?= htmlspecialchars($programa['descripcion']); ?></p>

            <div class="detalles">
                <p><i class="fa-regular fa-clock"></i>
                    <b>Horario:</b> <?= htmlspecialchars($programa['horario']); ?>
                </p>

                <p><i class="fa-solid fa-headset"></i>
                    <b>Operador:</b> <?= $programa['operador'] ?? 'No asignado'; ?>
                </p>

                <p><i class="fa-solid fa-user-gear"></i>
                    <b>Productor:</b> <?= $programa['productor'] ?? 'No asignado'; ?>
                </p>
            </div>

            <span class="etiqueta productor">Producción</span>
        </div>
    </section>

    <!-- SECCIÓN FX -->
    <section class="fx-section">
        <div class="fx-header">
            <h3><i class="fa-solid fa-volume-high"></i> Efectos de Sonido del Programa</h3>
        </div>

        <p class="subtexto">Gestión de efectos del programa</p>

        <div class="detalle">
            <div class="fx-lista">

                <?php
                // Traer FX del programa actual
                $queryFX = "SELECT id_fx, nombre, clasificacion_fx, ruta_archivo 
                            FROM fx 
                            WHERE id_programa = ?";
                $stmtFX = $Ruta->prepare($queryFX);
                $stmtFX->bind_param("i", $idPrograma);
                $stmtFX->execute();
                $resultFX = $stmtFX->get_result();

                if ($resultFX->num_rows > 0):
                    while ($fx = $resultFX->fetch_assoc()):
                ?>
                        <div class="fx-item" data-id="<?= $fx['id_fx'] ?>">
                            <span class="fx-etiqueta"><?= htmlspecialchars($fx['clasificacion_fx']); ?></span>

                            

                            <div class="menu-opciones">
                                <button class="edit" data-id="<?= $fx['id_fx'] ?>"><i class="fa-solid fa-pen"></i> Editar</button>
                                <button class="delete" data-id="<?= $fx['id_fx'] ?>"><i class="fa-solid fa-trash"></i> Eliminar</button>
                            </div>

                            <div class="fx-info">
                                <h4><?= htmlspecialchars($fx['nombre']); ?></h4>
                                <div class="fx-meta">
                                    <span class="duracion"><i class="fa-regular fa-clock"></i> —</span>
                                </div>
                            </div>

                            <button class="play" onclick="reproducirFX('../../<?= htmlspecialchars($fx['ruta_archivo']); ?>')">
                                <i class="fa-solid fa-play"></i>
                            </button>
                        </div>
                <?php
                    endwhile;
                else:
                    echo "<p class='no-fx'>📪 No hay FX cargados para este programa.</p>";
                endif;
                ?>
            </div>
        </div>
    </section>

</main>

<script src="../../js/reproducir.js"></script>
<script src="../../js/opciones.js"></script>
<script src="../../js/modal-detalle-op.js"></script>

<script>
let audioActual = null;

function reproducirFX(ruta) {
    if (audioActual) {
        audioActual.pause();
        audioActual.currentTime = 0;
    }
    audioActual = new Audio('../' + ruta);
    audioActual.play()
        .then(() => console.log("▶ Reproduciendo:", ruta))
        .catch(err => console.error("⚠ Error al reproducir FX:", err));
}
</script>

</body>
</html>

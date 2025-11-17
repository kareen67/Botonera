<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "operador") {
    header("Location: ../../login.php");
    exit();
}
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efectos de Sonido (FX) personales y institucionales, puede agregar propios y reproducir institucionales
    </title>
    <link rel="stylesheet" href="../../css/fx-institucionales.css">
    <link rel="stylesheet" href="../../css/detalle-fx-op.css">
    <link rel="stylesheet" href="../../css/opciones.css">
    <link rel="stylesheet" href="../../css/modal-agregar.css">

    <link rel="stylesheet" href="../../css/fondo-musical.css">
    <link rel="stylesheet" href="../../css/header.css">
    <!-- <link rel="stylesheet" href="../../css/fondo-musical.css"> -->
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
    <main class="contenido">
        <div class="descripcion">
            <h2><i class="fa-solid fa-volume-high"></i> Efectos de Sonido (FX)</h2>
            <p class="subtexto">Gestiona tus efectos personales y accede a la biblioteca institucional</p>
        </div>
        <section class="fx-section">
            <div class="fx-header">
                <h3><i class="fa-solid fa-music"></i> Biblioteca de FX</h3>
                <button id="openModal" class="agregar-fx">
                    <i class="fa-solid fa-plus"></i> Agregar FX
                </button>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" data-target="misFx"><i class="fa-regular fa-user"></i> Mis FX</button>
                <button class="tab" data-target="institucionales"><i class="fa-solid fa-building"></i> FX
                    Institucionales</button>
            </div>

            <!-- MIS FX (grid) -->
            <div id="misFx" class="fx-grid">          
                <?php
                    include_once("../../../controller/conexionBD.php");
                    session_start();

                    // Consultar FX del usuario actual (o todos si querés mostrar todos)
                    $id_usuario = $_SESSION["id_usuario"];
                    $query = "SELECT id_fx, nombre, clasificacion_fx, ruta_archivo FROM fx WHERE id_usuario = ?";
                    $stmt = $Ruta->prepare($query);
                    $stmt->bind_param("i", $id_usuario);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0):
                        while ($fx = $result->fetch_assoc()):
                            $nombre = htmlspecialchars($fx["nombre"]);
                            $clasificacion = htmlspecialchars($fx["clasificacion_fx"]);
                            $ruta = htmlspecialchars($fx["ruta_archivo"]);
                            $id_fx = $fx["id_fx"];
                    ?>
                <div class="fx-item" data-id="<?= $id_fx ?>">
                    <span class="fx-etiqueta"><?= $clasificacion ?></span>

                    <button class="menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <div class="menu-opciones">
                        <button class="edit" data-id="<?= $id_fx ?>"><i class="fa-solid fa-pen"></i> Editar</button>
                        <button class="delete" data-id="<?= $id_fx ?>"><i class="fa-solid fa-trash"></i> Eliminar</button>
                    </div>

                    <div class="fx-info">
                        <h4><?= $nombre ?></h4>
                        <div class="fx-meta">
                            <span class="duracion"><i class="fa-regular fa-clock"></i> — </span>
                        </div>
                    </div>
                    <!-- 🔊 Botón para reproducir -->
                    <button class="play" onclick="reproducirFX('../../<?= $ruta ?>')"><i class="fa-solid fa-play"></i></button>
                </div>
                <?php
                    endwhile;
                    else:
                        echo "<p>No tienes FX cargados.</p>";
                    endif;

                $stmt->close();
                ?>

            </div>

            <!-- FX INSTITUCIONALES  -->
            <div id="institucionales" class="fx-inst hidden">
                <?php
                    include_once("../../../controller/conexionBD.php");

                    $query = "SELECT id_fx, nombre, clasificacion_fx, ruta_archivo 
                            FROM fx 
                            WHERE id_usuario IS NULL AND id_programa IS NULL";

                    $result = $Ruta->query($query);

                    if ($result && $result->num_rows > 0):
                        while ($fx = $result->fetch_assoc()):
                            $nombre = htmlspecialchars($fx["nombre"]);
                            $clasificacion = htmlspecialchars($fx["clasificacion_fx"]);
                            $ruta = htmlspecialchars($fx["ruta_archivo"]);
                            $id_fx = $fx["id_fx"];
                ?>
                    <div class="fx-item" data-id="<?= $id_fx ?>">
                        <span class="fx-etiqueta"><?= $clasificacion ?></span>

                        <div class="fx-info">
                            <h4><?= $nombre ?></h4>
                            <div class="fx-meta">
                                <span class="duracion"><i class="fa-regular fa-clock"></i> — </span>
                            </div>
                        </div>

                        <!-- 🔊 Botón para reproducir -->
                        <button class="play" onclick="reproducirFX('../../<?= $ruta ?>')">
                            <i class="fa-solid fa-play"></i>
                        </button>
                    </div>

                <?php
                    endwhile;
                    else:
                        echo "<p>No hay FX institucionales disponibles.</p>";
                    endif;
                ?>
            </div>
        </section>

        <!-- MODAL -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <form action="../../../model/guardarFX.php" method="post" enctype="multipart/form-data">
                    <h2>Agregar Nuevo FX Personal </h2>
                    <label>Nombre:</label>
                    <input type="text" name="nombre" placeholder="Ej: Disparo Explosivo" required>
                    <label>Categoría:</label>
                    <input type="text" name="clasificacion" placeholder="Ej: Acción" required>
                    <label>Archivo:</label>
                    <input type="file" name="archivo" accept="audio/*" required>
                    <div class="modal-buttons">
                        <button class="btn cancelar" id="closeModal">Cancelar</button>
                        <input type="submit" class="btn primary" value="Guardar">
                    </div>
                </form>
            </div>
        </div>

    </main>
    <script src="../../js/opciones.js"></script>
    <script src="../../js/modal-tabs.js"></script>
    <script>
        // Botón play animado
        document.querySelectorAll('.play').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.classList.toggle('playing');
                btn.innerHTML = btn.classList.contains('playing')
                    ? '<i class="fa-solid fa-pause"></i>'
                    : '<i class="fa-solid fa-play"></i>';
            });
        });
    </script>
    <script>
let audioActual = null;

function reproducirFX(ruta) {
    // Si ya hay uno reproduciéndose, lo detenemos
    if (audioActual) {
        audioActual.pause();
        audioActual.currentTime = 0;
    }

    // Creamos un nuevo objeto de audio
    audioActual = new Audio('../' + ruta); // 🔸 Ajusta la ruta según la ubicación del archivo PHP
    audioActual.play()
        .then(() => console.log("Reproduciendo:", ruta))
        .catch(err => console.error("Error al reproducir FX:", err));
}
</script>

</body>

</html>
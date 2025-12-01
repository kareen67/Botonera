<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "operador") {
    header("Location: ../login.php");
    exit();   
}

include_once("../../../controller/conexionBD.php");

if (!isset($_GET['id_programa'])) {
    header("Location: panel-operador.php");
    exit();
}

$idPrograma = $_GET['id_programa'];

// Consulta del programa seleccionado
$query = "SELECT p.*, 
        (SELECT CONCAT(nombre) FROM usuario u 
         INNER JOIN operador_programa op ON u.id_usuario = op.id_usuario 
         WHERE op.id_programa = p.id_programa LIMIT 1) AS operador,
        (SELECT CONCAT(nombre) FROM usuario u 
         INNER JOIN productor_programa pp ON u.id_usuario = pp.id_usuario 
         WHERE pp.id_programa = p.id_programa LIMIT 1) AS productor
        FROM programa_radial p
        WHERE p.id_programa = '$idPrograma'";

$result = $Ruta->query($query);

if ($result && $result->num_rows > 0) {
    $programa = $result->fetch_assoc();
} else {
    echo "Programa no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FX del Programa - Productor</title>
    <link rel="stylesheet" href="../../css/detalle-fx-op.css" />
    <link rel="stylesheet" href="../../css/opciones.css">
    <link rel="stylesheet" href="../../css/modal-agregar.css">
    <link rel="stylesheet" href="../../css/fondo-musical.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/barra-reproducir.css">
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

        <a href="panel-operador.php" class="volver">
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
                <span class="etiqueta">Edición</span>
            </div>
        </section>

        <!-- SECCIÓN DE FX -->
        <section class="fx-section">
            <div class="fx-header">
                <h3><i class="fa-solid fa-volume-high"></i> Efectos de Sonido (FX)</h3>
                <button id="openModal" class="agregar-fx">
                    <i class="fa-solid fa-plus"></i> Agregar FX
                </button>
            </div>
            <p class="subtexto">Gestiona los efectos de sonido del programa</p>
            <div class="detalle">
                <div class="detalle">
                    <div class="fx-lista">
                        <!-- Tarjeta FX -->
                        <?php
                        include_once("../../../controller/conexionBD.php");

                        // Recibir el programa actual desde GET
                        $id_programa = intval($_GET["id_programa"]);

                        // Consulta: FX que pertenecen a este programa
                        $query = "SELECT id_fx, nombre, clasificacion_fx, ruta_archivo 
                                FROM fx 
                                WHERE id_programa = ?";

                        $stmt = $Ruta->prepare($query);
                        $stmt->bind_param("i", $id_programa);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Mostrar FX encontrados
                        if ($result->num_rows > 0):
                            while ($fx = $result->fetch_assoc()):
                                $id_fx = $fx["id_fx"];
                                $nombre = htmlspecialchars($fx["nombre"]);
                                $clasif = htmlspecialchars($fx["clasificacion_fx"]);
                                $ruta = htmlspecialchars($fx["ruta_archivo"]);
                        ?>
                                <div class="fx-item" data-id="<?= $id_fx ?>">
                                    <span class="fx-etiqueta"><?= $clasif ?></span>

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

                                    <button class="play" onclick="reproducirFX('../../<?= $ruta ?>')">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                </div>
                        <?php
                            endwhile;
                        else:
                            echo "<p class='no-fx'>📭 No hay FX cargados para este programa todavía.</p>";
                        endif;

                        $stmt->close();
                        ?>
                    </div>
                </div>
        </section>

        <!-- MODAL agregar fx programa -->
        <div id="modal" class="modal">
            <form action="../../../model/guardarFXprograma.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <h2>Agregar Nuevo FX de Programa</h2>

                    <!-- ID del programa oculto -->
                    <input type="hidden" name="id_programa" value="<?= $programa['id_programa']; ?>">

                    <label>Nombre:</label>
                    <input type="text" name="nombre" placeholder="Ej: Disparo Explosivo" required>

                    <label>Categoría:</label>
                    <input type="text" name="clasificacion" placeholder="Ej: Acción" required>

                    <label>Archivo:</label>
                    <input type="file" name="archivo" accept="audio/*" required>

                    <div class="modal-buttons">
                        <button type="button" class="btn cancelar" id="closeModal">Cancelar</button>
                        <input type="submit" value="Guardar" class="btn primary">
                    </div>
                </div>
            </form>
        </div>
        <!-- MODAL: EDITAR FX -->
        <div id="modalEditar" class="modal">
            <div class="modal-content">
                <h2>Editar FX de Programa</h2>
                <label>Nuevo nombre:</label>
                <input type="text" placeholder="Ej: Cortina Noticias">
                <label>Categoría:</label>
                <input type="text" placeholder="Ej: Informativo">
                <label>Archivo nuevo (opcional):</label>
                <input type="file">
                <div class="modal-buttons">
                    <button class="btn cancelar">Cancelar</button>
                    <button class="btn primary">Guardar cambios</button>
                </div>
            </div>
        </div>

        <!-- MODAL: CONFIRMAR ELIMINACIÓN -->
        <div id="modalEliminar" class="modal">
            <div class="modal-content">
                <h2>Eliminar FX de Programa</h2>
                <p>¿Seguro que querés eliminar este FX? Esta acción no se puede deshacer.</p>
                <div class="modal-buttons">
                    <button class="btn cancelar">Cancelar</button>
                    <button class="btn primary eliminar">Eliminar</button>
                </div>
            </div>
        </div>

    </main>



    <script src="../../js/reproducir.js"></script>
    <script src="../../js/player.js"></script>
    <script src="../../js/opciones.js"></script>
    <!-- <script src="../../js/modal-tabs.js"></script> -->
    <script src="../../js/modal-detalle-op.js"></script>
    <!-- <script src="../../js/barra-reproduccion.js"></script> -->

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
<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "jefe") {
    header("Location: ../../login.php");
    exit();
}
    // Header dinámico
include "../../layouts/header.php";
?> 


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efectos de Sonido (FX)</title>
    <link rel="stylesheet" href="../../css/fx-institucionales.css">
    <link rel="stylesheet" href="../../css/detalle-fx-op.css">
    <link rel="stylesheet" href="../../css/modal-agregar.css">

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
                <button class="tab" data-target="institucionales"><i class="fa-solid fa-building"></i> FX
                    Institucionales</button>
            </div>


            <!-- FX INSTITUCIONALES (tabla) -->
            <div id="" class="fx-tabla">
                <table>
                    <thead class="barra">
                        <tr>
                            <th>Nombre</th>
                            <th>Duración</th>
                            <th>Categoría</th>
                            <th>Archivo</th>
                            <th>Propietario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_fx_sistema">
                        <!-- <tr> 
                            <td>ID Estación</td>
                            <td>0:05</td>
                            <td><span class="categoria">ID</span></td>
                            <td>id_estacion.mp3</td>
                            <td>Sistema</td>
                            <td class="acciones">
                                <button class="play-2"><i class="fa-solid fa-play"></i></button>
                                <div class="acciones-ss">
                                    <button class="edit"><i class="fa-solid fa-pen"></i></button>
                                    <button class="delete"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Cortina Noticias</td>
                            <td>0:10</td>
                            <td><span class="categoria">Noticias</span></td>
                            <td>cortina_noticias.mp3</td>
                            <td>Sistema</td>
                            <td class="acciones">
                                <button class="play-2"><i class="fa-solid fa-play"></i></button>
                                <div class="acciones-ss">
                                    <button class="edit"><i class="fa-solid fa-pen"></i></button>
                                    <button class="delete"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>-->
                    </tbody>
                </table>
            </div>
        </section>

    </main>

     <!-- MODAL EDITAR -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <h2>Editar FX Institucional</h2>
            <label>Nombre:</label>
            <input type="text" id="edit-nombre">

            <label>Categoría:</label>
            <input type="text" id="edit-categoria">

            <label>Archivo:</label>
            <input type="file" id="edit-archivo">

            <div class="modal-buttons">
                <button class="btn cancelar editar-cancelar">Cancelar</button>
                <button class="btn primary">Guardar cambios</button>
            </div>
        </div>
    </div>

    <!-- MODAL ELIMINAR -->
    <div id="modalEliminar" class="modal">
        <div class="modal-content">
            <h2>¿Eliminar FX?</h2>
            <p>Esta acción no se puede deshacer.</p>

            <div class="modal-buttons">
                <button class="btn cancelar eliminar-cancelar">Cancelar</button>
                <button class="btn primary">Eliminar</button>
            </div>
        </div>
    </div>


    <!-- MODAL: AGREGAR FX -->
    <div id="modalAgregar" class="modal">
        <div class="modal-content">
            <form action="../../../model/guardarFXinstitucional.php" method="POST" enctype="multipart/form-data">
                <h2>Agregar Nuevo FX Institucional</h2>

                <label>Nombre:</label>
                <input type="text" name="nombre" required placeholder="Ej: Disparo Explosivo">

                <label>Categoría:</label>
                <input type="text" name="clasificacion" required placeholder="Ej: Acción">

                <label>Archivo:</label>
                <input type="file" name="archivo" required>                                                           
                <div class="modal-buttons">
                    <button class="btn cancelar">Cancelar</button>
                    <input type="submit" class="btn primary" value="Guardar">
                </div>
            </form>
        </div>
    </div>

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
    <!-- <script src="../../js/biblioteca.js"></script> -->
    <script src="../../js/fx-institucional.js"></script>
        <script src="../../js/modal-inst-acciones.js"></script>

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
    <!-- abrir modal fx agregar -->
   <script>
        document.getElementById("openModal").addEventListener("click", () => {
            document.getElementById("modalAgregar").style.display = "flex";
        });

        document.querySelectorAll(".modal").forEach(modal => {
            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
        //  Cerrar modal con botón "Cancelar" 
        document.querySelector("#modalAgregar .cancelar").addEventListener("click", () => {
            document.getElementById("modalAgregar").style.display = "none";
        });
    </script>
</body>

</html>
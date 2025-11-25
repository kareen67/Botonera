<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "jefe") {
    header("Location: ../../login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración principal</title>
    <link rel="stylesheet" href="../../css/panel-jefe.css">
    <link rel="stylesheet" href="../../css/fondo-musical.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="../../js/reproducir.js"></script>
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
    <div class="container">
        <h1>Panel de Administración</h1>
        <p class="pr">Gestiona usuarios, programas y asignaciones del sistema</p>

        <div class="tabs">
            <button class="tab active" data-target="usuarios"><i class="fa-regular fa-user"></i> Usuarios</button>
            <button class="tab" data-target="programas"><i class="fa-solid fa-microphone"></i> Programas</button>
            <button class="tab" data-target="asignaciones"><i class="fa-solid fa-link"></i> Asignaciones</button>
        </div>

        <!-- SECCIÓN USUARIOS -->
        <section id="usuarios" class="panel-section">

            <div class="card form-card">
                <form action="../../../model/guardarUsuario.php" method="post">
                    <h2>+ Crear Usuario</h2>
                    <p>Agregar un nuevo usuario al sistema</p>
                    <label>Nombre</label>
                    <input name="nombre" type="text" placeholder="Nombre completo" required>

                    <label>Email</label>
                    <input name="email" type="email" placeholder="email@ejemplo.com" required>

                    <label>Contraseña</label>
                    <input name="password" type="password" placeholder="Contraseña segura" required>

                    <label>Rol</label>
                    <select name="rol" required>
                        <option value="operador" >Operador</option>
                        <option value="productor" >Productor</option>
                        <option value="jefe" >Jefe de operadores</option>
                    </select>
                    <input type="submit" name="crear_usuario" value="Crear Usuario" class="btn-primary">
                </form>
            </div>


            <div class="card">
                <h2>Usuarios Existentes</h2>
                <p>Lista de usuarios registrados</p>

                <?php
                include_once("../../../controller/conexionBD.php");

                // Consulta de todos los usuarios registrados
                $query = "SELECT id_usuario, nombre, email, rol FROM usuario ORDER BY rol, nombre";
                $result = $Ruta->query($query);

                if ($result && $result->num_rows > 0):
                    while ($usuario = $result->fetch_assoc()):
                        $nombreCompleto = htmlspecialchars($usuario["nombre"]);
                        $email = htmlspecialchars($usuario["email"]);
                        $rol = htmlspecialchars($usuario["rol"]);
                ?>
                    <div class="usuario">
                        <div>
                            <h3><?= $nombreCompleto ?></h3>
                            <p><?= $email ?></p>
                        </div>
                        <div class="acciones">
                            <span class="rol <?= strtolower($rol) ?>"><?= ucfirst($rol) ?></span>

                            <button class="menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>

                            <div class="menu-opciones">
                                <!-- <button class="edit"><i class="fa-solid fa-pen"></i> Editar</button> -->

                                <!-- FORMULARIO PARA ELIMINAR USUARIO -->
                                <form action="../../../model/eliminarUsuario.php" method="POST" 
                                    onsubmit="return confirmarEliminacion(<?= $usuario['id_usuario'] ?>)">
                                    <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                                    <button type="submit" class="delete">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                    endwhile;
                else:
                    echo "<p>No hay usuarios registrados.</p>";
                endif;
                ?>
                
            </div>
        </section>

        <!-- SECCIÓN PROGRAMAS -->
        <section id="programas" class="panel-section hidden">
            <div class="card form-card">
                <form action="../../../model/guardarPrograma.php" method="post">
                <h2>+ Crear Programa</h2>
                <p>Agregar un nuevo programa al sistema</p>
                <label>Nombre del programa</label>
                <input name="nombre" type="text" placeholder="Ej: Mañanas en Vivo" required>
                <label>Horario</label>
                <input name="horario" type="text" placeholder="Ej: 08:00 - 10:00" required>
                <label>Descripción</label>
                <textarea name="descripcion" placeholder="Descripción del programa" required></textarea>
                <input name="crear_programa" class="btn-primary" type="submit" value="Crear Programa">
                </form>
            </div>

            <div class="card">
                <h2>Programas Existentes</h2>
                <p>Lista de programas registrados</p>
                <?php
                    include_once("../../../controller/conexionBD.php");

                    // Consultar todos los programas
                    $query = "SELECT id_programa, nombre, horario, descripcion FROM programa_radial ORDER BY nombre ASC";
                    $result = $Ruta->query($query);

                    if ($result && $result->num_rows > 0):
                        while ($programa = $result->fetch_assoc()):
                            $id = $programa["id_programa"];
                            $nombre = htmlspecialchars($programa["nombre"]);
                            $horario = htmlspecialchars($programa["horario"]);
                            $descripcion = htmlspecialchars($programa["descripcion"]);
                    ?>
                        <div class="usuario">
                            <div>
                                <h3><?= $nombre ?></h3>
                                <p><?= $descripcion ?></p>
                            </div>
                            <div class="info">
                                <span class="horario"><?= $horario ?></span>
                            </div>
                            <div class="acciones">
                                <button class="menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <div class="menu-opciones">
                                    <button class="edit"><i class="fa-solid fa-pen"></i> Editar</button>

                                    <!-- FORM para eliminar un programa -->
                                    <form action="../../../model/eliminarPrograma.php" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este programa y todos sus datos relacionados?');">
                                        <input type="hidden" name="id_programa" value="<?= $id; ?>">
                                        <button type="submit" class="delete">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>  
                            </div>
                        </div>
                    <?php
                        endwhile;
                    else:
                        echo "<p>No hay programas registrados.</p>";
                    endif;
                    ?>
            </div>
        </section>

        <!-- SECCIÓN ASIGNACIONES -->
        <section id="asignaciones" class="panel-section hidden">
            <div class="card form-card">
                <form action="../../../model/guardarAsignacion.php" method="post">
                <h2>+ Nueva Asignación</h2>
                <p>Asignar un operador a un programa</p>
                <?php
                include_once("../../../controller/conexionBD.php");
                ?>

                <label>Programa</label>
                <select name="programa" id="programa" required>
                    <option value="">Seleccione un programa...</option>
                    <?php
                    $queryProgramas = "SELECT id_programa, nombre FROM programa_radial ORDER BY nombre ASC";
                    $resultProgramas = $Ruta->query($queryProgramas);

                    if ($resultProgramas && $resultProgramas->num_rows > 0) {
                        while ($row = $resultProgramas->fetch_assoc()) {
                            echo "<option value='{$row['id_programa']}'>{$row['nombre']}</option>";
                        }
                    } else {
                        echo "<option disabled>No hay programas disponibles</option>";
                    }
                    ?>
                </select>

                <label>Operador</label>
                <select name="operador" id="operador" required>
                    <option value="">Seleccione un operador...</option>
                    <?php
                    $queryOperadores = "SELECT id_usuario, nombre FROM usuario WHERE rol = 'operador' ORDER BY nombre ASC";
                    $resultOperadores = $Ruta->query($queryOperadores);

                    if ($resultOperadores && $resultOperadores->num_rows > 0) {
                        while ($row = $resultOperadores->fetch_assoc()) {
                            echo "<option value='{$row['id_usuario']}'>{$row['nombre']}</option>";
                        }
                    } else {
                        echo "<option disabled>No hay operadores registrados</option>";
                    }
                    ?>
                </select>

                <label>Productor</label>
                <select name="productor" id="productor" required>
                    <option value="">Seleccione un productor...</option>
                    <?php
                    $queryProductores = "SELECT id_usuario, nombre FROM usuario WHERE rol = 'productor' ORDER BY nombre ASC";
                    $resultProductores = $Ruta->query($queryProductores);

                    if ($resultProductores && $resultProductores->num_rows > 0) {
                        while ($row = $resultProductores->fetch_assoc()) {
                            echo "<option value='{$row['id_usuario']}'>{$row['nombre']}</option>";
                        }
                    } else {
                        echo "<option disabled>No hay productores registrados</option>";
                    }
                    ?>
                </select>
                <label>Fecha</label>
                <input type="date" name="fecha" id="" placeholder="Fecha">
                <input type="submit" class="btn-primary" value="Crear Asignacion">
                </form>
            </div>

            <div class="card">
                <h2>Asignaciones Existentes</h2>
                <p>Lista de asignaciones activas</p>

                <div class="usuario">
                    <div class="info">
                        <h3>Ana Rodríguez</h3>
                        <p>operador@radio.com</p>
                    </div>

                    <div class="acciones">
                        <button class="menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>

                        <div class="menu-opciones">
                            <button class="edit"><i class="fa-solid fa-pen"></i> Editar</button>
                            <button class="delete"><i class="fa-solid fa-trash"></i> Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="../../js/panel-admin.js"></script>

    <script>
        const tabs = document.querySelectorAll('.tab');
        const sections = document.querySelectorAll('.panel-section');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                sections.forEach(s => s.classList.add('hidden'));
                tab.classList.add('active');
                document.getElementById(tab.dataset.target).classList.remove('hidden');
            });
        });
    </script>
</body>

</html>
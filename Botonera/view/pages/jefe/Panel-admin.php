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
                            <!-- Botones opcionales -->
                            <button class="edit" data-id="<?= $usuario['id_usuario'] ?>"><i class="fa-solid fa-pen"></i></button>
                            <button class="delete" data-id="<?= $usuario['id_usuario'] ?>"><i class="fa-solid fa-trash"></i></button>
                            <span class="rol <?= strtolower($rol) ?>"><?= ucfirst($rol) ?></span>
                        </div>
                    </div>
                <?php
                    endwhile;
                else:
                    echo "<p>No hay usuarios registrados.</p>";
                endif;
                ?>
                <div class="usuario">
                    <div>
                        <h3>Ana Rodríguez</h3>
                        <p>operador@radio.com</p>
                    </div>
                    <div class="acciones">
                        <!-- <button><i class="fa-solid fa-pen"></i></button>
                        <button><i class="fa-solid fa-trash"></i></button> -->
                        <span class="rol operador">Operador</span>
                    </div>
                </div>

                <div class="usuario">
                    <div>
                        <h3>Luis García</h3>
                        <p>productor@radio.com</p>
                    </div>
                    <div class="acciones">
                        <button><i class="fa-solid fa-pen"></i></button>
                        <button><i class="fa-solid fa-trash"></i></button>
                        <span class="rol productor">Productor</span>
                    </div>
                </div>
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

                <div class="usuario">
                    <div>
                        <h3>Mañanas en Vivo</h3>
                        <p>Programa diario de noticias y entretenimiento</p>
                    </div>
                    <div class="info">
                        <span class="horario">08:00 - 10:00</span>
                        <div class="acciones">
                            <button><i class="fa-solid fa-pen"></i></button>
                            <button><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>

                <div class="usuario">
                    <div>
                        <h3>Tarde Musical</h3>
                        <p>Las mejores notas musicales</p>
                    </div>
                    <div class="info">
                        <span class="horario">08:00 - 10:00</span>

                        <div class="acciones">
                            <button><i class="fa-solid fa-pen"></i></button>
                            <button><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECCIÓN ASIGNACIONES -->
        <section id="asignaciones" class="panel-section hidden">
            <div class="card form-card">
                <h2>+ Nueva Asignación</h2>
                <p>Asignar un operador a un programa</p>
                <label>Programa</label>
                <select>
                    <option>Mañanas en Vivo</option>
                    <option>Tarde Musical</option>
                </select>
                <label>Operador</label>
                <select>
                    <option>Ana Rodríguez</option>
                    <option>Luis García</option>
                </select>
                <button class="btn-primary">Crear Asignación</button>
            </div>

            <div class="card">
                <h2>Asignaciones Existentes</h2>
                <p>Lista de asignaciones activas</p>

                <div class="usuario">
                    <div>
                        <h3>Mañanas en Vivo</h3>
                        <p>Operador: Ana Rodríguez</p>
                    </div>
                    <div class="acciones">
                        <button><i class="fa-solid fa-pen"></i> </button>
                        <button><i class="fa-solid fa-trash"></i> </button>
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
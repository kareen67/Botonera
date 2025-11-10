<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../controller/conexionBD.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar que se hayan enviado todos los datos
    if (
        !empty($_POST["programa"]) &&
        !empty($_POST["operador"]) &&
        !empty($_POST["productor"]) &&
        !empty($_POST["fecha"])
    ) {
        $id_programa = intval($_POST["programa"]);
        $id_operador = intval($_POST["operador"]);
        $id_productor = intval($_POST["productor"]);
        $fecha = $_POST["fecha"];

        // ✅ Insertar asignación en operador_programa
        $stmtOperador = $Ruta->prepare("
            INSERT INTO operador_programa (id_usuario, id_programa, fecha_asignacion)
            VALUES (?, ?, ?)
        ");
        $stmtOperador->bind_param("iis", $id_operador, $id_programa, $fecha);
        $okOperador = $stmtOperador->execute();
        $stmtOperador->close();

        // ✅ Insertar asignación en productor_programa
        $stmtProductor = $Ruta->prepare("
            INSERT INTO productor_programa (id_usuario, id_programa)
            VALUES (?, ?)
        ");
        $stmtProductor->bind_param("ii", $id_productor, $id_programa);
        $okProductor = $stmtProductor->execute();
        $stmtProductor->close();

        // ✅ Verificar resultados
        if ($okOperador && $okProductor) {
            echo "<script>
                alert('✅ Asignación creada correctamente');
                window.location.href='../view/pages/jefe/Panel-admin.php';
            </script>";
        } else {
            echo "<script>
                alert('❌ Error al registrar la asignación');
                window.location.href='../view/pages/jefe/Panel-admin.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('⚠️ Todos los campos son obligatorios');
            window.location.href='../view/pages/jefe/Panel-admin.php';
        </script>";
    }
}
?>
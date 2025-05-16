<?php
session_start();
if (!isset($_SESSION['numero_reloj'])) {
    header("Location: login.php");
    exit();
}

$numero_reloj = $_SESSION['numero_reloj'];

$conexion = new mysqli("localhost", "root", "", "vacaciones");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM solicitudes WHERE numero_reloj = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $numero_reloj);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Solicitudes</title>
    <link rel="stylesheet" href="css/historial.css">
</head>
<body>
    <section class="top">
        <h1 class="titulo">Historial de Solicitudes</h1>
        <a href="solicitar_vacaciones.php" class="boton-agregar">+ Nueva Solicitud</a>
    </section>

    <section class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>Fecha de Solicitud</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['fecha_solicitud']) ?></td>
                    <td><?= htmlspecialchars($fila['fecha_inicio']) ?></td>
                    <td><?= htmlspecialchars($fila['fecha_fin']) ?></td>
                    <td><?= htmlspecialchars($fila['motivo']) ?></td>
                    <td><?= htmlspecialchars($fila['estado']) ?></td>
                    <td>
                        <a href="editar_solicitud.php?id=<?= $fila['id'] ?>" class="boton editar">Editar</a>
                        <a href="eliminar_solicitud.php?id=<?= $fila['id'] ?>" class="boton eliminar" onclick="return confirm('¿Estás seguro de eliminar esta solicitud?')">Borrar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>

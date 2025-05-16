<?php
session_start();
if (!isset($_SESSION['numero_reloj']) || !isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

$numero_reloj = $_SESSION['numero_reloj'];
$nombre_real = $_SESSION['nombre']; 

$conexion = new mysqli("localhost", "root", "", "vacaciones");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mapa_aprobadores = [
    "GALVAN ADAME MARIA ANTONIETA" => "Antonieta Galván",
    "GARCIA ALVARADO ADALBERTO" => "Adalberto García",
    "VACA MALCHAN JOSE ROLANDO" => "Rolando Vaca",
    "RIOS AGUILAR DANIELA DENISSE" => "Daniela Ríos",
    "LARA VILLA FERNANDO" => "Fernando Lara",
    "TEJEDA ARMANDO" => "Armando Tejeda",
    "HOLGUIN GARCIA JORGE ARTURO" => "Jorge Holguín"
];

$sql_tipo = "SELECT tipo_usuario FROM usuario WHERE numero_reloj = ?";
$stmt_tipo = $conexion->prepare($sql_tipo);
$stmt_tipo->bind_param("s", $numero_reloj);
$stmt_tipo->execute();
$result_tipo = $stmt_tipo->get_result();
$row_tipo = $result_tipo->fetch_assoc();
$tipo_usuario = $row_tipo['tipo_usuario'];
$stmt_tipo->close();

if ($tipo_usuario === 'admin') {
    $alias = $mapa_aprobadores[$nombre_real] ?? null;

    if (!$alias) {
        die("Su nombre no esta en la lista de administradores. Por favor contacte al soporte tecnico.");
    }

    $sql = "
        SELECT s.*, u.nombre AS nombre_empleado
        FROM solicitudes s
        INNER JOIN usuario u ON s.numero_reloj = u.numero_reloj
        WHERE u.aprobador = ?
        ORDER BY s.fecha_solicitud DESC
    ";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $alias);

} else {

    $sql = "SELECT * FROM solicitudes WHERE numero_reloj = ? ORDER BY fecha_solicitud DESC";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $numero_reloj);
}

$stmt->execute();
$resultado = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Solicitudes</title>
    <link rel="stylesheet" href="css/aprobar.css">
</head>
<body>
    <section class="top">
        <h1 class="titulo">Historial de Solicitudes</h1>
        <?php if ($tipo_usuario !== 'admin'): ?>
            <a href="solicitar_vacaciones.php" class="boton-agregar">+ Nueva Solicitud</a>
        <?php endif; ?>
    </section>

    <section class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <?php if ($tipo_usuario === 'admin'): ?>
                        <th>Empleado</th>
                    <?php endif; ?>
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
                    <?php if ($tipo_usuario === 'admin'): ?>
                        <td><?= htmlspecialchars($fila['nombre_empleado']) ?></td>
                    <?php endif; ?>
                    <td><?= htmlspecialchars($fila['fecha_solicitud']) ?></td>
                    <td><?= htmlspecialchars($fila['fecha_inicio']) ?></td>
                    <td><?= htmlspecialchars($fila['fecha_fin']) ?></td>
                    <td><?= htmlspecialchars($fila['motivo']) ?></td>
                    <td><?= htmlspecialchars($fila['estado']) ?></td>
                    <td>
                        <?php if ($tipo_usuario === 'admin' && $fila['estado'] === 'pendiente'): ?>
                            <a href="aprobar.php?id=<?= $fila['id'] ?>&accion=aprobar" class="boton aprobar">Aprobar</a>
                            <a href="aprobar.php?id=<?= $fila['id'] ?>&accion=denegar" class="boton denegar">Denegar</a>
                        <?php elseif ($tipo_usuario !== 'admin'): ?>
                            <a href="editar_solicitud.php?id=<?= $fila['id'] ?>" class="boton editar">Editar</a>
                            <a href="eliminar_solicitud.php?id=<?= $fila['id'] ?>" class="boton eliminar" onclick="return confirm('¿Estás seguro de eliminar esta solicitud?')">Borrar</a>
                        <?php endif; ?>
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

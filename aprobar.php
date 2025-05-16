<?php
session_start();
if (!isset($_SESSION['numero_reloj']) || !isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "vacaciones");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$numero_reloj = $_SESSION['numero_reloj'];
$nombre_real = $_SESSION['nombre'];

$mapa_aprobadores = [
    "GALVAN ADAME MARIA ANTONIETA" => "Antonieta Galván",
    "GARCIA ALVARADO ADALBERTO" => "Adalberto García",
    "VACA MALCHAN JOSE ROLANDO" => "Rolando Vaca",
    "RIOS AGUILAR DANIELA DENISSE" => "Daniela Ríos",
    "LARA VILLA FERNANDO" => "Fernando Lara",
    "TEJEDA ARMANDO" => "Armando Tejeda",
    "HOLGUIN GARCIA JORGE ARTURO" => "Jorge Holguín"
];

$alias_aprobador = $mapa_aprobadores[$nombre_real] ?? null;
if (!$alias_aprobador) {
    die("Tu nombre no está autorizado como aprobador.");
}

$sql_tipo = "SELECT tipo_usuario FROM usuario WHERE numero_reloj = ?";
$stmt_tipo = $conexion->prepare($sql_tipo);
$stmt_tipo->bind_param("s", $numero_reloj);
$stmt_tipo->execute();
$result_tipo = $stmt_tipo->get_result();
$tipo_usuario = $result_tipo->fetch_assoc()['tipo_usuario'];
$stmt_tipo->close();

if ($tipo_usuario !== 'admin') {
    die("No tienes permiso para aprobar solicitudes.");
}

if (!isset($_GET['id']) || !isset($_GET['accion'])) {
    die("Parámetros inválidos.");
}

$id = intval($_GET['id']);
$accion = $_GET['accion'] === 'aprobar' ? 'Aprobada' : 'Denegada';

$sql_verificar = "
    SELECT s.id 
    FROM solicitudes s 
    INNER JOIN usuario u ON s.numero_reloj = u.numero_reloj 
    WHERE s.id = ? AND u.aprobador = ?
";
$stmt_verificar = $conexion->prepare($sql_verificar);
$stmt_verificar->bind_param("is", $id, $alias_aprobador);
$stmt_verificar->execute();
$result_verificar = $stmt_verificar->get_result();

if ($result_verificar->num_rows === 0) {
    die("No tienes permiso para modificar esta solicitud.");
}
$stmt_verificar->close();

$sql_actualizar = "UPDATE solicitudes SET estado = ? WHERE id = ?";
$stmt_actualizar = $conexion->prepare($sql_actualizar);
$stmt_actualizar->bind_param("si", $accion, $id);
if ($stmt_actualizar->execute()) {
    echo "Solicitud $accion correctamente. <a href='admin_index.php'>Volver al inicio</a>";
} else {
    echo "Error al actualizar la solicitud.";
}
$stmt_actualizar->close();
$conexion->close();
?>

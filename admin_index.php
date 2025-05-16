<?php
session_start();
if (!isset($_SESSION['numero_reloj'])) {
    header("Location: login.php");
    exit;
}

include('conexion.php');

$numero_reloj = $_SESSION['numero_reloj'];
$query = "SELECT nombre, tipo_usuario, dias_vacaciones FROM usuario WHERE numero_reloj = '$numero_reloj'";
$resultado = mysqli_query($conn, $query);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    echo "Error al obtener los datos del usuario.";
    exit;
}

$usuario = mysqli_fetch_assoc($resultado);

if ($usuario['tipo_usuario'] !== 'admin') {
    echo "Acceso denegado. Esta sección es solo para administradores.";
    exit;
}

$nombre = htmlspecialchars($usuario['nombre']);
$dias_vacaciones = $usuario['dias_vacaciones'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="contenedor">
        <section class="top">
            <h1 class="titulo">Sistema de Vacaciones - Admin</h1>
        </section>

        <div class="info">
            <h1>SALUDOS, <?php echo $nombre; ?></h1><br>
            <h2>Días de vacaciones disponibles: <?php echo $dias_vacaciones; ?></h2>
            <br><br>

            <div class="acciones">
                <button onclick="location.href='aprobar_solicitudes.php'" class="send-button">Aprobar Solicitudes</button>
                <button onclick="location.href='solicitar_vacaciones.php'" class="send-button">Solicitar Vacaciones</button>
                <button onclick="location.href='historial.php'" class="send-button">Ver Peticiones</button>
                <button onclick="location.href='buscar.php'" class="send-button">Ver Todas Las Solicitudes</button>
                <button onclick="location.href='politica.php'" class="send-button">Ver Política</button>
                <button onclick="location.href='contacto.php'" class="send-button">Contacto y soporte</button>
                <button onclick="location.href='logout.php'" class="send-button">Cerrar Sesión</button>
            </div>
        </div>

        <div class="footer">
            <div class="direccion">
                <h2>Dirección</h2>
                <p>32575, Libre Comercio 32, Americas, Juárez, Chih.</p>
            </div>
            <div class="tel">
                <h2>Teléfono</h2>
                <p>656 171 9693</p>
            </div>
        </div>
    </div>
</body>
</html>

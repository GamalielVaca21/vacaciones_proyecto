<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Usuario</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="contenedor">
        <section class="top">
            <h1 class="titulo">Sistema de Vacaciones</h1>
            <!--<img id="logo" src="recursos/logo_en.jpg" alt="Logo Empresa">-->
        </section>

        <div class="info">
            <h1>
            <?php
                session_start();
                if (isset($_SESSION['nombre'])) {
                    $nombre = $_SESSION['nombre'];
                    echo "SALUDOS, " . htmlspecialchars($nombre);
                } else {
                    echo "No se ha iniciado sesión.";
                    exit;
                }
            ?>
            </h1><br>

            <?php
                include('conexion.php');

                $numero_reloj = $_SESSION['numero_reloj'];

                // Obtener días asignados inicialmente
                $query_total = "SELECT dias_vacaciones FROM usuario WHERE numero_reloj = '$numero_reloj'";
                $resultado_total = mysqli_query($conn, $query_total);
                $fila_total = mysqli_fetch_assoc($resultado_total);
                $dias_total = $fila_total['dias_vacaciones'];

                // Calcular días ya usados (solo solicitudes aprobadas)
                $query_usados = "SELECT SUM(DATEDIFF(fecha_fin, fecha_inicio) + 1) AS dias_usados
                                 FROM solicitudes
                                 WHERE numero_reloj = '$numero_reloj' AND estado = 'aprobado'";
                $resultado_usados = mysqli_query($conn, $query_usados);
                $fila_usados = mysqli_fetch_assoc($resultado_usados);
                $dias_usados = $fila_usados['dias_usados'] ?? 0;

                // Calcular días restantes
                $dias_disponibles = $dias_total - $dias_usados;
                echo "<h2>Días de vacaciones disponibles: $dias_disponibles</h2>";
            ?>
            <br><br>

            <div class="acciones">
                <button onclick="location.href='solicitar_vacaciones.php'" class="send-button">Solicitar Vacaciones</button>
                <button onclick="location.href='historial.php'" class="send-button">Ver Peticiones</button>
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

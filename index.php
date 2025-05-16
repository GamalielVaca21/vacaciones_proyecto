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
                if (isset($_SESSION['nombre']) && isset($_SESSION['numero_reloj'])) {
                    $nombre = $_SESSION['nombre'];
                    $numero_reloj = $_SESSION['numero_reloj'];
                    echo "SALUDOS, " . htmlspecialchars($nombre);
                } else {
                    echo "No se ha iniciado sesión.";
                    exit; 
                }
            ?>
            </h1><br>

            <?php
                include('conexion.php');

                // Obtener días base
                $query = "SELECT dias_vacaciones FROM usuario WHERE numero_reloj = '$numero_reloj'";
                $resultado = mysqli_query($conn, $query);
                $dias_disponibles = 0;

                if ($fila = mysqli_fetch_assoc($resultado)) {
                    $dias_disponibles = $fila['dias_vacaciones'];
                }

                // Restar días aprobados
                $query_aprobadas = "SELECT fecha_inicio, fecha_fin FROM solicitudes WHERE numero_reloj = '$numero_reloj' AND estado = 'aprobada'";
                $resultado_aprobadas = mysqli_query($conn, $query_aprobadas);

                $dias_usados = 0;
                while ($fila = mysqli_fetch_assoc($resultado_aprobadas)) {
                    $inicio = new DateTime($fila['fecha_inicio']);
                    $fin = new DateTime($fila['fecha_fin']);
                    $dias = $inicio->diff($fin)->days + 1; // +1 para incluir ambos días
                    $dias_usados += $dias;
                }

                $dias_finales = max($dias_disponibles - $dias_usados, 0);
                echo "<h2>Días de vacaciones disponibles: $dias_finales</h2>";

                // Actualizar base de datos si es necesario
                $update = "UPDATE usuario SET dias_vacaciones = $dias_finales WHERE numero_reloj = '$numero_reloj'";
                mysqli_query($conn, $update);
            ?>
            <br><br>

            <div class="acciones">
                <button onclick="location.href='solicitar_vacaciones.php'" class="send-button">Solicitar Vacaciones</button>
                <button onclick="location.href='historial.php'" class="send-button">Ver Peticiones</button>
                <button onclick="location.href='politica.php'" class="send-button">Ver Politica</button>
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

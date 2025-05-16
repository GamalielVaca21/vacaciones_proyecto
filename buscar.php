<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$nombreUsuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Solicitudes</title>
    <link rel="stylesheet" href="css/buscar.css">
</head>
<body>
    <div class="container">
        <section class="top">
                <h2>Buscar solicitudes por número de reloj</h2>
                <p class="descripcion">Ingresa el número de reloj para consultar todas las solicitudes registradas para ese empleado.</p>
        </section>
        <input type="text" id="reloj" placeholder="Número de reloj"><br><br>
        <button onclick="buscar()">Buscar</button>
        <button onclick="location.href='admin_index.php'" class="send-button">Volver</button>
        <ul id="resultados"></ul>
    </div>

    <script>
    function buscar() {
        const numero = document.getElementById("reloj").value;
        fetch(`http://localhost:3006/solicitudes/${numero}`)
            .then(res => res.json())
            .then(data => {
                const lista = document.getElementById("resultados");
                lista.innerHTML = "";

                if (data.length === 0) {
                    lista.innerHTML = "<li>No se encontraron solicitudes</li>";
                    return;
                }

                data.forEach(solicitud => {
                    const item = document.createElement("li");
                    item.textContent = `Del ${solicitud.fecha_inicio} al ${solicitud.fecha_fin} - Motivo: ${solicitud.motivo} - Estado: ${solicitud.estado}`;
                    lista.appendChild(item);
                });
            })
            .catch(err => {
                console.error("Error:", err);
                document.getElementById("resultados").innerHTML = "<li>Error al buscar datos</li>";
            });
    }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Vacaciones</title>
    <link rel="stylesheet" href="css/solicitar_vacaciones.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <section class="top">
            <h1 class="titulo">Solicitud de Vacaciones</h1>
    </section>
    <form action="guardar_solicitud.php" method="POST">
        <label for="rango_fecha">Selecciona el rango de fechas:</label>
        <input type="text" id="rango_fecha" name="rango_fecha" required><br><br>

        <label for="comentarios">Motivo (opcional):</label><br>
        <textarea name="motivo" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="Enviar Solicitud">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#rango_fecha", {
            mode: "range",
            dateFormat: "Y-m-d"
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Contacto y Soporte</title>
  <link rel="stylesheet" href="css/contacto.css">
</head>
<body>
  <h2>Contacto y Soporte</h2>
  <p>¿Tienes problemas o preguntas sobre el sistema de vacaciones? Llena el siguiente formulario:</p>

  <form action="contacto_envio.php" method="POST">
    <div class="form-group">
      <label for="nombre">Nombre:</label>
      <input id="nombre" name="nombre" type="text" required />
    </div>
    <div class="form-group">
      <label for="correo">Correo:</label>
      <input id="correo" name="correo" type="email" required />
    </div>
    <div class="form-group">
      <label for="mensaje">Mensaje:</label>
      <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
    </div>
    <button type="submit">Enviar</button>
  </form>

</body>
</html>

<!-- politicas.php -->
<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Políticas de Vacaciones</title>
  <link rel="stylesheet" href="css/politica.css">
</head>
<body>
  <div class="container">
    <h2>Políticas de Vacaciones</h2>
    <ul>
      <li>Las vacaciones deben solicitarse con al menos 10 días de anticipación.</li>
      <li>No se permite tomar más de 10 días consecutivos sin autorización especial.</li>
      <li>Las vacaciones acumuladas del año anterior deben usarse antes de marzo.</li>
      <li>Los administradores pueden aprobar o rechazar solicitudes según disponibilidad del equipo.</li>
      <li>En caso de emergencia, se pueden solicitar vacaciones con menos aviso, sujeto a aprobación directa.</li>
    </ul>
  </div>
</body>
</html>

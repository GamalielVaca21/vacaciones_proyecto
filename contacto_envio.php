<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    if (!$correo) {
        echo "Correo inválido.";
        exit();
    }

    $destinatario = "al228284@alumnos.uacj.mx"; 
    $asunto = "Soporte - Mensaje de $nombre";
    $cuerpo = "Nombre: $nombre\nCorreo: $correo\n\nMensaje:\n$mensaje";

    $headers = "From: $correo\r\n";
    $headers .= "Reply-To: $correo\r\n";

    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
        echo "Mensaje enviado correctamente.";
    } else {
        echo "Hubo un error al enviar el mensaje. Intenta más tarde.";
    }
} else {
    echo "Acceso no permitido.";
}
?>

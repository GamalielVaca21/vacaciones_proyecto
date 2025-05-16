<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['numero_reloj'])) {
    $nombre = $_POST['nombre'];
    $numero_reloj = $_POST['numero_reloj'];

    $conn = new mysqli('localhost:3306', 'root', '', 'vacaciones');
    
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }

    $nombre = $conn->real_escape_string($nombre);
    $numero_reloj = $conn->real_escape_string($numero_reloj);

    $sql = "SELECT tipo_usuario FROM usuario WHERE LOWER(TRIM(nombre)) = LOWER(TRIM('$nombre')) AND LOWER(TRIM(numero_reloj)) = LOWER(TRIM('$numero_reloj'))";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "Cuenta no existente. Intente de nuevo o <a href='signup.html'>crea una cuenta.</a>";
    } else {
        $row = $result->fetch_assoc();
        $tipo_usuario = $row['tipo_usuario'];

        $_SESSION["nombre"] = $nombre;
        $_SESSION['numero_reloj'] = $numero_reloj; 

        if ($tipo_usuario == "user") {
            header("Location: index.php");
            exit;
        } elseif ($tipo_usuario == "admin") {
            header("Location: admin_index.php");
            exit;
        } else {
            echo "Tipo de usuario no válido.";
        }
    }

    $conn->close();
}
?>

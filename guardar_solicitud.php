<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['nombre'])) {
    echo "Debes iniciar sesión.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_reloj = $_SESSION['numero_reloj'];
    if (isset($_POST['rango_fecha'])) {
    $fechas = explode(" to ", $_POST['rango_fecha']);

    if (count($fechas) == 2) {
        $fecha_inicio = $fechas[0];
        $fecha_fin = $fechas[1];
    } else {
        echo "Error: rango de fechas no válido.";
        exit();
    }
} else {
    echo "Error: no se recibió el rango de fechas.";
    exit();
}
    $motivo = $_POST['motivo'];

    $sql = "INSERT INTO solicitudes (numero_reloj, fecha_inicio, fecha_fin, motivo, estado)
            VALUES ('$numero_reloj', '$fecha_inicio', '$fecha_fin', '$motivo', 'pendiente')";

    if ($conn->query($sql) === TRUE) {
        echo "Solicitud enviada correctamente.";
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Acceso no permitido.";
}

$conn->close();
?>

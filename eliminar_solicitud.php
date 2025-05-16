<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['numero_reloj'])) {
    echo "Debes iniciar sesión.";
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $numero_reloj = $_SESSION['numero_reloj'];

    $sql = "DELETE FROM solicitudes WHERE id = ? AND numero_reloj = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $numero_reloj);

    if ($stmt->execute()) {
        header("Location: historial.php");
        exit();
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Solicitud no especificada.";
}

$conn->close();
?>

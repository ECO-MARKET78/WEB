<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    // Para este ejemplo, aseguramos que el usuario existe en la base de datos
    $result = $conn->query("SELECT id_usuario FROM usuarios LIMIT 1");
    $user = $result->fetch_assoc();
    $_SESSION['id_usuario'] = $user['id_usuario'];
}

$id_usuario = $_SESSION['id_usuario'];
$id_producto = $_GET['id'];
$cantidad = 1; // Cantidad por defecto

// Verificar si el producto ya está en el carrito
$result = $conn->query("SELECT * FROM carrito WHERE id_usuario = $id_usuario AND id_producto = $id_producto");

if ($result->num_rows > 0) {
    // Si el producto ya está en el carrito, actualizar la cantidad
    $conn->query("UPDATE carrito SET cantidad = cantidad + $cantidad WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
} else {
    // Si el producto no está en el carrito, insertarlo
    $conn->query("INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES ($id_usuario, $id_producto, $cantidad)");
}

// Redirigir de vuelta a la página anterior
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

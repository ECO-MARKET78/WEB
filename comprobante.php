<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

$id_pedido = $_GET['id_pedido'];
$nombre_completo = $_GET['nombre_completo'];
$direccion = $_GET['direccion'];
$calle_principal = $_GET['calle_principal'];
$ciudad = $_GET['ciudad'];
$email = $_GET['email'];
$fecha = date('Y-m-d');

$query = "SELECT dp.id_producto, p.nombre, dp.cantidad, p.precio 
          FROM detalles_pedido dp 
          JOIN productos p ON dp.id_producto = p.id_producto 
          WHERE dp.id_pedido = '$id_pedido'";
$result = $conn->query($query) or die($conn->error);

$subtotal = 0;
$detalles = [];

while ($row = $result->fetch_assoc()) {
    $detalles[] = $row;
    $subtotal += $row['cantidad'] * $row['precio'];
}

$iva = $subtotal * 0.15;
$total = $subtotal + $iva;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pedido - ECO-MARKET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <img src="imagenes/logo.png" alt="ECO-MARKET" class="logo">
        <h1>ECO-MARKET</h1>
    </header>
    <main>
        <h2>Comprobante de Pedido</h2>
        <p>Nombre: <?php echo htmlspecialchars($nombre_completo); ?></p>
        <p>Dirección: <?php echo htmlspecialchars($direccion); ?></p>
        <p>Calle Principal: <?php echo htmlspecialchars($calle_principal); ?></p>
        <p>Ciudad: <?php echo htmlspecialchars($ciudad); ?></p>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <p>Fecha: <?php echo htmlspecialchars($fecha); ?></p>
        
        <h3>Detalles del Pedido</h3>
        <table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
            <?php foreach ($detalles as $detalle): ?>
            <tr>
                <td><?php echo htmlspecialchars($detalle['nombre']); ?></td>
                <td><?php echo htmlspecialchars($detalle['cantidad']); ?></td>
                <td><?php echo htmlspecialchars($detalle['precio']); ?></td>
                <td><?php echo htmlspecialchars($detalle['cantidad'] * $detalle['precio']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p>Subtotal: <?php echo htmlspecialchars($subtotal); ?></p>
        <p>IVA (15%): <?php echo htmlspecialchars($iva); ?></p>
        <p>Total: <?php echo htmlspecialchars($total); ?></p>

        <button onclick="window.location.href='index.php'">Volver a la Página Principal</button>
        <button onclick="window.print()">Imprimir</button>
    </main>
</body>
</html>

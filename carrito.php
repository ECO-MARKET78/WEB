<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $id_producto = $_POST['id_producto'];
        
        if ($action == 'update') {
            $cantidad = $_POST['cantidad'];
            $conn->query("UPDATE carrito SET cantidad = $cantidad WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
        } elseif ($action == 'delete') {
            $conn->query("DELETE FROM carrito WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
        }
    }
}

$query = "
    SELECT productos.id_producto, productos.nombre, productos.imagen, carrito.cantidad, productos.precio 
    FROM carrito 
    JOIN productos ON carrito.id_producto = productos.id_producto 
    WHERE carrito.id_usuario = $id_usuario
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito - ECO-MARKET</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 2rem;
            text-align: center;
        }
        main {
            padding: 2rem;
        }
        .carrito-contenido {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .carrito-item {
            background-color: white;
            padding: 2rem;
            border: 1px solid #ddd;
            border-radius: 50px;
            width: calc(33% - rem);
            box-shadow: 0 3px 50px rgba(0, 0, 0, 9);
        }
        .carrito-item img {
            max-width: 100%;
            height: auto;
        }
        .carrito-item p {
            margin: 0.1rem 0;
        }
        .carrito-item form {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .carrito-item form input[type="number"] {
            width: 50px;
        }
        .carrito-item form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 50px;
        }
        .carrito-item form button[type="submit"] {
            background-color: #f44336;
        }
        .totales {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .totales p {
            font-size: 1.9rem;
            font-weight: bold;
        }
        .botones {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
        }
        .botones a, .botones button {
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 0.5rem 10rem;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }
        .botones .atras {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <header>
        <img src="imagenes/logo.png" alt="ECO-MARKET">
        <h1>ECO-MARKET</h1>
    </header>
    <main>
        <h2>Carrito de Compras</h2>
        <div class="carrito-contenido">
            <?php
            $total = 0;
            while ($row = $result->fetch_assoc()):
                $subtotal = $row['cantidad'] * $row['precio'];
                $total += $subtotal;
            ?>
                <div class="carrito-item">
                    <img src="imagenes/productos/<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre']; ?>">
                    <p><?php echo $row['nombre']; ?></p>
                    <p>Precio: $<?php echo $row['precio']; ?></p>
                    <form method="post">
                        <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                        <input type="number" name="cantidad" value="<?php echo $row['cantidad']; ?>" min="1">
                        <button type="submit" name="action" value="update">Actualizar</button>
                        <button type="submit" name="action" value="delete">Eliminar</button>
                    </form>
                    <p>Subtotal: $<?php echo $subtotal; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="totales">
            <p>Total: $<?php echo $total; ?></p>
        </div>
        <div class="botones">
            <a href="formulario_cliente.php" class="realizar-pedido">Realizar Pedido</a>
            <a href="index.php" class="atras">Atrás</a>
        </div>
    </main>
</body>
</html>

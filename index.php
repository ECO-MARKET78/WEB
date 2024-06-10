<?php
include 'config.php';
session_start();

$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $cantidad = 1;

    if ($id_usuario) {
        $result = $conn->query("SELECT * FROM carrito WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
        if ($result->num_rows > 0) {
            $conn->query("UPDATE carrito SET cantidad = cantidad + 1 WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
        } else {
            $conn->query("INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES ($id_usuario, $id_producto, $cantidad)");
        }
    } else {
        header('Location: login.php');
        exit();
    }
}

$result = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ECO-MARKET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <img src="imagenes/logo.png" alt="ECO-MARKET" class="logo">
        <h1>ECO-MARKET</h1>
        <form action="busqueda.php" method="get">
            <input type="text" name="query" placeholder="Buscar productos...">
            <button type="submit">Buscar</button>
        </form>
        <div class="carrito">
            <a href="carrito.php"><img src="imagenes/carrito.png" alt="Carrito">
                <span class="count">
                    <?php
                    if ($id_usuario) {
                        $result_count = $conn->query("SELECT SUM(cantidad) AS total_cantidad FROM carrito WHERE id_usuario = $id_usuario");
                        $row_count = $result_count->fetch_assoc();
                        echo $row_count['total_cantidad'] ? $row_count['total_cantidad'] : 0;
                    } else {
                        echo 0;
                    }
                    ?>
                </span>
            </a>
        </div>
    </header>
    
    <!-- Navegación -->
    <nav>
        <ul>
            <li><a href="index.php">Todos los Productos</a></li>
            <li><a href="categoria.php?id_categoria=1">Lácteos</a></li>
            <li><a href="categoria.php?id_categoria=2">Bebidas</a></li>
            <li><a href="categoria.php?id_categoria=3">Alimentos de Primera Necesidad</a></li>
            <li><a href="categoria.php?id_categoria=4">Aseo</a></li>
        </ul>
    </nav>
    
    <!-- Contenido principal -->
    <main>
        <div class="productos">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="producto">
                    <img src="imagenes/productos/<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre']; ?>">
                    <h3><?php echo $row['nombre']; ?></h3>
                    <p>$<?php echo $row['precio']; ?></p>
                    <!-- Formulario para añadir al carrito -->
                    <form method="post">
                        <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                        <button type="submit">Añadir al Carrito</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
</body>
</html>

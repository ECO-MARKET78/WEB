<?php
include 'config.php';
session_start();

$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

$query = isset($_GET['query']) ? $_GET['query'] : '';

$result = $conn->query("SELECT * FROM productos WHERE nombre LIKE '%$query%'");

if ($result === false) {
    die('Error en la consulta: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda - ECO-MARKET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <img src="imagenes/logo.png" alt="ECO-MARKET" class="logo">
        <h1>ECO-MARKET</h1>
        <form action="busqueda.php" method="get">
            <input type="text" name="query" value="<?php echo htmlspecialchars($query); ?>" placeholder="Buscar productos...">
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
    <nav>
        <ul>
            <li><a href="index.php">Todos los Productos</a></li>
            <li><a href="categoria.php?id_categoria=1">Lácteos</a></li>
            <li><a href="categoria.php?id_categoria=2">Bebidas</a></li>
            <li><a href="categoria.php?id_categoria=3">Alimentos de Primera Necesidad</a></li>
            <li><a href="categoria.php?id_categoria=4">Aseo</a></li>
        </ul>
    </nav>
    <main>
        <h2>Resultados de Búsqueda para "<?php echo htmlspecialchars($query); ?>"</h2>
        <div class="productos">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="producto">
                        <img src="imagenes/productos/<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre']; ?>">
                        <h3><?php echo $row['nombre']; ?></h3>
                        <p>$<?php echo $row['precio']; ?></p>
                        <form method="post" action="index.php">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                            <button type="submit">Añadir al Carrito</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No se encontraron productos para "<?php echo htmlspecialchars($query); ?>"</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>

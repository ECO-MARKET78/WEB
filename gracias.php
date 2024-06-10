<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gracias - ECO-MARKET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <img src="imagenes/logo.png" alt="ECO-MARKET">
        <h1>ECO-MARKET</h1>
        <form action="buscar.php" method="get">
            <input type="text" name="query" placeholder="Buscar productos...">
            <input type="submit" value="Buscar">
        </form>
        <a href="carrito.php">Carrito de Compras</a>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="categoria.php?id=1">Lácteos</a></li>
            <li><a href="categoria.php?id=2">Bebidas</a></li>
            <li><a href="categoria.php?id=3">Alimentos de primera necesidad</a></li>
            <li><a href="categoria.php?id=4">Aseo</a></li>
        </ul>
    </nav>
    <main>
        <h2>Gracias por tu compra</h2>
        <p>Tu pedido ha sido realizado con éxito.</p>
        <a href="index.php">Volver al Inicio</a>
    </main>
</body>
</html>

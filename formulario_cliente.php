<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Cliente - ECO-MARKET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <img src="imagenes/logo.png" alt="ECO-MARKET" class="logo">
        <h1>ECO-MARKET</h1>
    </header>
    <main>
        <h2>Datos del Cliente</h2>
        <form action="realizar_pedido.php" method="post" class="form-cliente">
            <div class="form-group">
                <label for="nombre_completo">Nombre Completo:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="calle_principal">Calle Principal:</label>
                <input type="text" id="calle_principal" name="calle_principal" required>
            </div>
            <div class="form-group">
                <label for="ciudad">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="celular">Celular:</label>
                <input type="text" id="celular" name="celular" required>
            </div>
            <button type="submit" class="btn-submit">Realizar Pedido</button>
        </form>
    </main>
</body>
</html>

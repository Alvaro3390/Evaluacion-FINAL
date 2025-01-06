<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.html');
    exit;
}

// Productos de ejemplo
$productos = [
    ['id' => 1, 'nombre' => 'Vino Tinto', 'precio' => 20.00],
    ['id' => 2, 'nombre' => 'Queso Brie', 'precio' => 15.00],
    ['id' => 3, 'nombre' => 'Chocolate Premium', 'precio' => 10.00],
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
    // Agregar producto al carrito
    $producto_id = $_POST['producto_id'];
    $producto_encontrado = null;

    // Buscar producto
    foreach ($productos as $producto) {
        if ($producto['id'] == $producto_id) {
            $producto_encontrado = $producto;
            break;
        }
    }

    // Si el producto es encontrado, agregarlo al carrito
    if ($producto_encontrado) {
        $_SESSION['carrito'][] = $producto_encontrado;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Tienda Gourmet</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Bienvenido, <?php echo $_SESSION['email']; ?></h2>
        <h3>Productos Disponibles</h3>
        
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                            <p class="card-text">Precio: $<?php echo $producto['precio']; ?></p>
                            <form method="POST" action="productos.php">
                                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Carrito de Compras</h3>
        <ul>
            <?php
            $total = 0;
            if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                foreach ($_SESSION['carrito'] as $item) {
                    echo "<li>{$item['nombre']} - $ {$item['precio']}</li>";
                    $total += $item['precio'];
                }
                echo "<strong>Total: $ {$total}</strong>";
            } else {
                echo "<li>El carrito está vacío.</li>";
            }
            ?>
        </ul>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</body>
</html>

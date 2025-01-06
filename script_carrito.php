<?php
include('conexion.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Debes iniciar sesión para acceder al carrito.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Agregar productos al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Actualizar cantidad de productos
    if (isset($_POST['actualizar'])) {
        foreach ($_POST['cantidad'] as $producto_id => $cantidad) {
            // Obtener el precio del producto
            $stmt = $pdo->prepare("SELECT precio FROM PRODUCTOS WHERE ID = :producto_id");
            $stmt->execute(['producto_id' => $producto_id]);
            $producto = $stmt->fetch();
            if ($producto) {
                $precio = $producto['precio'];
                $monto_total = $precio * $cantidad;
                
                // Actualizar la cantidad y monto total en el carrito
                $stmt = $pdo->prepare("UPDATE CARRITO SET cantidad = :cantidad, monto_total = :monto_total WHERE ID_usuario = :user_id AND ID_producto = :producto_id");
                $stmt->execute(['cantidad' => $cantidad, 'monto_total' => $monto_total, 'user_id' => $user_id, 'producto_id' => $producto_id]);
            }
        }
        echo "Carrito actualizado.";
    }

    // Eliminar productos del carrito
    if (isset($_POST['eliminar'])) {
        $producto_id = $_POST['eliminar'];
        $stmt = $pdo->prepare("DELETE FROM CARRITO WHERE ID_usuario = :user_id AND ID = :producto_id");
        $stmt->execute(['user_id' => $user_id, 'producto_id' => $producto_id]);
        echo "Producto eliminado del carrito.";
    }
}
?>

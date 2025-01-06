<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Consulta SQL para insertar el producto en la base de datos
    $sql = "INSERT INTO PRODUCTOS (nombre, descripcion, categoria, precio, cantidad)
            VALUES ('$nombre_producto', '$descripcion', '$categoria', '$precio', '$cantidad')";

    if ($conn->query($sql) === TRUE) {
        echo "Producto registrado exitosamente!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!-- Formulario HTML para el registro de productos -->
<form method="POST" action="registro_producto.php">
    <div>
        <label>Nombre del Producto:</label>
        <input type="text" name="nombre_producto" required>
    </div>
    <div>
        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea>
    </div>
    <div>
        <label>Categoría:</label>
        <input type="text" name="categoria" required>
    </div>
    <div>
        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" required>
    </div>
    <div>
        <label>Cantidad en Inventario:</label>
        <input type="number" name="cantidad" required>
    </div>
    <div>
        <button type="submit">Registrar Producto</button>
    </div>
</form>

<form action="carrito.php" method="POST">
    <h2>Carrito de Compras</h2>

    <!-- Selección del producto -->
    <div>
        <label for="producto">Producto:</label>
        <select name="producto" id="producto" required>
            <?php
            include('conexion.php');
            // Obtener productos desde la base de datos
            $stmt = $pdo->query("SELECT * FROM PRODUCTOS");
            while ($producto = $stmt->fetch()) {
                echo "<option value='" . $producto['ID'] . "'>" . $producto['nombre'] . " - $" . $producto['precio'] . "</option>";
            }
            ?>
        </select>
    </div>

    <!-- Ingreso de cantidad -->
    <div>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" min="1" required>
    </div>

    <!-- Monto total -->
    <div>
        <label for="total">Monto Total:</label>
        <input type="text" id="total" name="total" readonly>
    </div>

    <button type="submit" name="agregar">Agregar al Carrito</button>
</form>

<script>
    // Función para calcular el total
    document.getElementById('cantidad').addEventListener('input', function() {
        const cantidad = document.getElementById('cantidad').value;
        const precio = document.getElementById('producto').selectedOptions[0].dataset.precio;
        const total = cantidad * precio;
        document.getElementById('total').value = total.toFixed(2);
    });
</script>







<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Carrito de Compras</h2>

        <?php
        include('conexion.php');
        session_start();

        if (!isset($_SESSION['user_id'])) {
            echo "<p>Debes iniciar sesión para acceder al carrito.</p>";
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("SELECT C.ID, P.nombre, P.precio, C.cantidad, C.monto_total 
                                FROM CARRITO C
                                INNER JOIN PRODUCTOS P ON C.ID_producto = P.ID
                                WHERE C.ID_usuario = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $productos_carrito = $stmt->fetchAll();

        if ($productos_carrito) {
            echo "<table class='table'>";
            echo "<thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Monto Total</th><th>Acción</th></tr></thead>";
            echo "<tbody>";

            foreach ($productos_carrito as $producto) {
                echo "<tr>";
                echo "<td>" . $producto['nombre'] . "</td>";
                echo "<td><input type='number' name='cantidad[" . $producto['ID'] . "]' value='" . $producto['cantidad'] . "' min='1' required></td>";
                echo "<td>$" . $producto['precio'] . "</td>";
                echo "<td>$" . $producto['monto_total'] . "</td>";
                echo "<td><button type='submit' name='eliminar' value='" . $producto['ID'] . "'>Eliminar</button></td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";

            // Calcular el total
            $stmt = $pdo->prepare("SELECT SUM(monto_total) AS total FROM CARRITO WHERE ID_usuario = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            $total = $stmt->fetch()['total'];
            echo "<h3>Total a Pagar: $" . $total . "</h3>";
            echo "<button type='submit' name='actualizar'>Actualizar Carrito</button>";
        } else {
            echo "<p>Tu carrito está vacío.</p>";
        }
        ?>
    </div>
</body>
</html>

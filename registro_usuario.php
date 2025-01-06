<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitizar el email
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Hash de la contraseña
    $direccion = htmlspecialchars($_POST['direccion']);
    $telefono = htmlspecialchars($_POST['telefono']);

    // Validar el email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El correo electrónico no es válido.";
        exit();
    }

    // Consulta SQL para insertar el usuario en la base de datos (Usando Prepared Statements)
    $sql = "INSERT INTO USUARIOS (nombre, email, contraseña, direccion, telefono)
            VALUES (?, ?, ?, ?, ?)";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    
    // Vincular los parámetros
    $stmt->bind_param("sssss", $nombre, $email, $contraseña, $direccion, $telefono);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Registro exitoso!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>

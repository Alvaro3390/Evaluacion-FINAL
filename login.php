<?php
session_start();

// Datos de ejemplo para la autenticación (en un caso real esto debe ser recuperado de la base de datos)
$usuarios = [
    'usuario1@example.com' => 'password123',
    'usuario2@example.com' => 'password456'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Verificar credenciales
    if (array_key_exists($email, $usuarios) && $usuarios[$email] == $contraseña) {
        // Iniciar sesión
        $_SESSION['email'] = $email;
        $_SESSION['carrito'] = []; // Inicializar carrito vacío
        header('Location: productos.php');
        exit;
    } else {
        echo '<div class="alert alert-danger">Credenciales incorrectas</div>';
    }
}
?>

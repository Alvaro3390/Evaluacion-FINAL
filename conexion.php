<?php
$host = 'localhost';  // Cambia según tu configuración
$db = 'GOURMET';
$user = 'Alvaro';     // Usuario de la base de datos
$pass = '12345678';   // Contraseña de la base de datos
$port = 3307;         // Puerto MySQL (si es necesario)

$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";  // Agregado el puerto
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Conexión exitosa";  // Solo para pruebas
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage();  // Muestra detalles del error
}
?>

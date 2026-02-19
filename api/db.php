<?php
// Configuración de la base de datos basada en MainQuery.sql
$host = "localhost";
$db_name = "inventario_tecnologia";
$username = "root";
$password = ""; // Cambia esto si tienes contraseña en tu servidor local
$charset = "utf8mb4";

try {
    $dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    // Conexión exitosa
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
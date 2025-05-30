<?php
// Archivo de conexión global para $conn

$envFile = __DIR__ . "/.env";
if (!file_exists($envFile)) {
    throw new Exception("Archivo .env no encontrado en: " . $envFile);
}
$env = parse_ini_file($envFile);
$requiredKeys = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
foreach ($requiredKeys as $key) {
    if (!isset($env[$key])) {
        throw new Exception("La clave {$key} no se encuentra en el archivo .env");
    }
}
$host = $env["DB_HOST"];
$db_name = $env["DB_NAME"];
$username = $env["DB_USER"];
$password = $env["DB_PASS"];
$dsn = "mysql:host={$host};dbname={$db_name};charset=utf8";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $exception) {
    throw new Exception("Error de conexión: " . $exception->getMessage());
}

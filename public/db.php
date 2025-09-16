<?php
// Connexion PDO réutilisable
$config = require __DIR__ . '/config.php';

$dsn = sprintf('pgsql:host=%s;port=%d;dbname=%s', $config['host'], $config['port'], $config['dbname']);

try {
    $pdo = new PDO($dsn, $config['user'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Erreur de connexion à la base de données: ' . htmlspecialchars($e->getMessage());
    exit;
}

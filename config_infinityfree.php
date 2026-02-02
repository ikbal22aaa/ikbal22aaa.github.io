<?php
// config_infinityfree.php - Configuration file template for InfinityFree hosting
// IMPORTANT: Rename this file to config.php after uploading to InfinityFree

// InfinityFree Database credentials
// Replace these values with your actual InfinityFree database credentials
$host = 'sql203.infinityfree.com';  // InfinityFree MySQL host
$db_name = 'if0_40987611_database_1';  // InfinityFree database name
$username = 'if0_40987611';  // InfinityFree database username
$password = 'gkbRciAYTSM26e';  // InfinityFree database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
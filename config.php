<?php
// config.php

// Détection de l'environnement (Local vs Production)
$is_cli = (php_sapi_name() === 'cli');
$is_local = $is_cli || ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1');

if ($is_local) {
    // Configuration Locale (XAMPP)
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'ecommerce_db'; // Nom de la base de données locale
} else {
    // InfinityFree Database credentials
    $host = 'sql203.infinityfree.com';
    $db_name = 'if0_40987611_database_1';
    $username = 'if0_40987611';
    $password = 'gkbRciAYTSM26e';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Attempt to connect without dbname to check if it's just missing
    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Si on est en local et que la connexion sans DB fonctionne, on peut proposer de créer la DB
        if ($is_local) {
             // Optionnel: Création automatique de la BDD si elle n'existe pas
             // $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name`");
             // $pdo->exec("USE `$db_name`");
        }
        
    } catch (PDOException $e2) {
        die("Erreur de connexion : " . $e2->getMessage());
    }
}

// Configuration PayPal
if (!defined('PAYPAL_CLIENT_ID')) {
    define('PAYPAL_CLIENT_ID', 'Ab5--e2YTXl1jaDUkDNIU45Ipb4sIIEccrHQMrwim6sCyK4B5F0oXvSD9rCSvi0WEUBs0Hx1MmqWim-W');
}
if (!defined('PAYPAL_CLIENT_SECRET')) {
    define('PAYPAL_CLIENT_SECRET', 'EMENuP35KmP65skjH9UuX9xWSKeKN2gDCPHJskA86mqbs1BwKnLfS5Zp-AEGEsIRn4qrkDS2ytaLEp8m');
}
if (!defined('PAYPAL_MODE')) {
    define('PAYPAL_MODE', 'sandbox'); // sandbox ou live
}
if (!defined('PAYPAL_API_URL')) {
    define('PAYPAL_API_URL', (PAYPAL_MODE === 'sandbox') ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com');
}
?>

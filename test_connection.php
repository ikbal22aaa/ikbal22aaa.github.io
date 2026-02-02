<?php
// test_connection.php - Test database connection to InfinityFree
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test de connexion à la base de données InfinityFree</h2>";

// Load database configuration
require 'config.php';

echo "<p><strong>Configuration:</strong></p>";
echo "<ul>";
echo "<li>Host: " . htmlspecialchars($host) . "</li>";
echo "<li>Database: " . htmlspecialchars($db_name) . "</li>";
echo "<li>Username: " . htmlspecialchars($username) . "</li>";
echo "<li>Password: " . str_repeat('*', strlen($password)) . "</li>";
echo "</ul>";

echo "<hr>";

// Test 1: Check if PDO MySQL driver is available
echo "<h3>Test 1: Vérification du driver PDO MySQL</h3>";
if (extension_loaded('pdo_mysql')) {
    echo "<p style='color: green;'>✅ Extension PDO MySQL est chargée</p>";
} else {
    echo "<p style='color: red;'>❌ Extension PDO MySQL n'est PAS chargée</p>";
    die("Impossible de continuer sans PDO MySQL");
}

// Test 2: Try to connect to the database
echo "<h3>Test 2: Tentative de connexion à la base de données</h3>";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✅ Connexion réussie à la base de données!</p>";
    
    // Test 3: Try a simple query
    echo "<h3>Test 3: Test d'une requête simple</h3>";
    $stmt = $pdo->query("SELECT DATABASE() as current_db, VERSION() as mysql_version");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p style='color: green;'>✅ Requête exécutée avec succès!</p>";
    echo "<ul>";
    echo "<li>Base de données actuelle: " . htmlspecialchars($result['current_db']) . "</li>";
    echo "<li>Version MySQL: " . htmlspecialchars($result['mysql_version']) . "</li>";
    echo "</ul>";
    
    // Test 4: Check if tables exist
    echo "<h3>Test 4: Vérification des tables</h3>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "<p style='color: green;'>✅ Tables trouvées (" . count($tables) . "):</p>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . htmlspecialchars($table) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: orange;'>⚠️ Aucune table trouvée dans la base de données</p>";
        echo "<p>Vous devez importer le fichier SQL dans phpMyAdmin</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ Erreur de connexion:</p>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
    echo htmlspecialchars($e->getMessage());
    echo "</pre>";
    
    echo "<h3>Solutions possibles:</h3>";
    echo "<ul>";
    echo "<li><strong>SQLSTATE[HY000] [1045]</strong> - Mot de passe ou nom d'utilisateur incorrect</li>";
    echo "<li><strong>SQLSTATE[HY000] [2002]</strong> - Impossible de se connecter au serveur (vérifiez le nom d'hôte)</li>";
    echo "<li><strong>SQLSTATE[HY000] [1049]</strong> - Base de données inconnue (vérifiez le nom de la base)</li>";
    echo "<li><strong>Connection timed out</strong> - InfinityFree bloque les connexions externes (normal en développement local)</li>";
    echo "</ul>";
    
    echo "<h3>Note importante:</h3>";
    echo "<p style='background: #fff3cd; padding: 10px; border-left: 4px solid #ffc107;'>";
    echo "⚠️ <strong>InfinityFree bloque les connexions MySQL externes!</strong><br>";
    echo "Vous ne pouvez PAS vous connecter à la base de données InfinityFree depuis votre ordinateur local (XAMPP).<br>";
    echo "La connexion ne fonctionnera QUE lorsque les fichiers seront uploadés sur le serveur InfinityFree.";
    echo "</p>";
}
?>

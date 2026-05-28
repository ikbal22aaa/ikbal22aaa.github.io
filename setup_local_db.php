<?php
// setup_local_db.php
// Script pour configurer la base de données locale automatiquement

$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'ecommerce_db';

echo "<h1>Configuration de la Base de Données Locale</h1>";

try {
    // 1. Connexion au serveur MySQL sans sélectionner de base de données
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p>✅ Connexion au serveur MySQL réussie.</p>";

    // 2. Création de la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>✅ Base de données '$db_name' vérifiée/créée.</p>";

    // 3. Sélection de la base de données
    $pdo->exec("USE `$db_name`");
    
    // 4. Vérification si les tables existent
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        echo "<p>⚠️ Les tables n'existent pas. Tentative d'importation...</p>";
        
        // Lecture du fichier SQL
        $sqlFile = 'hosting_ready.sql';
        if (file_exists($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            
            // Exécution du SQL (peut prendre un peu de temps)
            $pdo->exec($sql);
            echo "<p>✅ Tables importées avec succès depuis '$sqlFile'.</p>";
        } else {
            echo "<p style='color:red'>❌ Erreur : Le fichier '$sqlFile' est introuvable !</p>";
        }
    } else {
        echo "<p>✅ Les tables existent déjà. Pas besoin d'importer.</p>";
    }

    echo "<h3>🎉 Configuration terminée avec succès !</h3>";
    echo "<p>Vous pouvez maintenant accéder à votre site : <a href='index.php'>Aller à l'accueil</a></p>";

} catch (PDOException $e) {
    echo "<h3 style='color:red'>Erreur :</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "<p>Vérifiez que votre mot de passe root est bien vide ou modifiez le fichier ce fichier.</p>";
    }
}
?>

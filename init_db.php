<?php
// init_db.php
require 'config.php';

try {
    $sql = file_get_contents('setup.sql');
    $pdo->exec($sql);
    echo "Base de données et tables créées avec succès ! <br>";
    echo "Compte Admin créé : admin@shop.com / admin123";
} catch (PDOException $e) {
    echo "Erreur lors de l'initialisation : " . $e->getMessage();
}
?>

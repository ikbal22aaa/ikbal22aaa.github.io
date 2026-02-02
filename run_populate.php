<?php
// run_populate.php
require 'config.php';

try {
    $sql = file_get_contents('populate_data.sql');
    
    // Remove USE statement and split by semicolons
    $sql = str_replace('USE ecommerce_db;', '', $sql);
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    $count = 0;
    foreach ($statements as $statement) {
        if (!empty($statement) && !str_starts_with($statement, '--')) {
            $pdo->exec($statement);
            $count++;
        }
    }
    
    echo "✓ Script exécuté avec succès !<br>";
    echo "✓ $count instructions SQL exécutées<br><br>";
    
    // Verify
    $cats = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    $prods = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    
    echo "📦 Catégories dans la base : $cats<br>";
    echo "🛍️ Produits dans la base : $prods<br>";
    
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>

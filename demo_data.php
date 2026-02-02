<?php
// demo_data.php
require 'config.php';

try {
    // Check if products exist
    $stmt = $pdo->query("SELECT count(*) FROM products");
    if ($stmt->fetchColumn() > 0) {
        die("Les produits existent déjà.");
    }

    // Get Category IDs
    $cats = $pdo->query("SELECT name, id FROM categories")->fetchAll(PDO::FETCH_KEY_PAIR);
    $catMap = $cats;


    $products = [
        [
            'category_id' => $catMap['Électronique'],
            'name' => 'Smartphone Pro X',
            'description' => 'Un smartphone puissant avec un excellent appareil photo et une autonomie longue durée.',
            'price' => 85000,
            'stock_quantity' => 15,
            'image_url' => 'assets/images/cat_electronics.jpg'
        ],
        [
            'category_id' => $catMap['Électronique'],
            'name' => 'Casque Audio Sans Fil',
            'description' => 'Son haute fidélité avec réduction de bruit active pour une immersion totale.',
            'price' => 12500,
            'stock_quantity' => 30,
            'image_url' => 'assets/images/cat_electronics.jpg'
        ],
        [
            'category_id' => $catMap['Mode'],
            'name' => 'Chemise en Lin Premium',
            'description' => 'Confort et élégance pour toutes les occasions. 100% lin naturel.',
            'price' => 4500,
            'stock_quantity' => 50,
            'image_url' => 'assets/images/cat_fashion.jpg'
        ],
        [
            'category_id' => $catMap['Maison'],
            'name' => 'Lampe Design Minimaliste',
            'description' => 'Éclairez votre intérieur avec style grâce à cette lampe moderne et économique.',
            'price' => 6800,
            'stock_quantity' => 20,
            'image_url' => 'assets/images/cat_home.jpg'
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO products (category_id, name, description, price, stock_quantity, image_url) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($products as $p) {
        $stmt->execute([
            $p['category_id'], $p['name'], $p['description'], $p['price'], $p['stock_quantity'], $p['image_url']
        ]);
    }

    echo "Produits de démo ajoutés avec succès !";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

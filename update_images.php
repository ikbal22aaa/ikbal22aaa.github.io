<?php
// update_images.php - Script to update missing product images
require 'config.php';

echo "=== Updating Product Images ===" . PHP_EOL . PHP_EOL;

// Define the products with their new image URLs
$updates = [
    [
        'name' => 'iPhone 15 Pro',
        'url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-1inch-naturaltitanium?wid=1280&hei=1280&fmt=jpeg&qlt=90&.v=1692845702275'
    ],
    [
        'name' => 'Canon EOS R6',
        'url' => 'https://i.imgur.com/9KqXZYL.jpg'
    ]
];

// Update each product
$stmt = $pdo->prepare("UPDATE products SET image_url = :url WHERE name = :name");

foreach ($updates as $update) {
    try {
        $stmt->execute([
            ':url' => $update['url'],
            ':name' => $update['name']
        ]);
        echo "✓ Updated: " . $update['name'] . PHP_EOL;
        echo "  New URL: " . $update['url'] . PHP_EOL . PHP_EOL;
    } catch (PDOException $e) {
        echo "✗ Error updating " . $update['name'] . ": " . $e->getMessage() . PHP_EOL . PHP_EOL;
    }
}

// Verify the updates
echo "=== Verification ===" . PHP_EOL . PHP_EOL;
$verify = $pdo->query("SELECT id, name, image_url FROM products WHERE name IN ('iPhone 15 Pro', 'Canon EOS R6')");

while ($row = $verify->fetch()) {
    echo "ID: " . $row['id'] . PHP_EOL;
    echo "Name: " . $row['name'] . PHP_EOL;
    echo "Image URL: " . $row['image_url'] . PHP_EOL;
    echo "---" . PHP_EOL;
}

echo PHP_EOL . "Done!" . PHP_EOL;
?>

<?php
// remove_products.php - Script to remove specific products from database
require 'config.php';

echo "=== Removing Products ===" . PHP_EOL . PHP_EOL;

// Products to remove
$productsToRemove = [
    'Canon EOS R6',
    'Ceinture en Cuir',
    'Ballon de Football'
];

// First, show the products that will be deleted
echo "Products to be deleted:" . PHP_EOL;
$placeholders = str_repeat('?,', count($productsToRemove) - 1) . '?';
$stmt = $pdo->prepare("SELECT id, name, category_id, price FROM products WHERE name IN ($placeholders)");
$stmt->execute($productsToRemove);
$products = $stmt->fetchAll();

foreach ($products as $product) {
    echo "  - ID: " . $product['id'] . " | " . $product['name'] . " | Price: " . $product['price'] . " DA" . PHP_EOL;
}

echo PHP_EOL . "Deleting..." . PHP_EOL . PHP_EOL;

// Delete the products
$stmt = $pdo->prepare("DELETE FROM products WHERE name IN ($placeholders)");
$stmt->execute($productsToRemove);

$deletedCount = $stmt->rowCount();

echo "✓ Successfully deleted " . $deletedCount . " product(s)" . PHP_EOL . PHP_EOL;

// Verify deletion
echo "=== Verification ===" . PHP_EOL;
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM products WHERE name IN ($placeholders)");
$stmt->execute($productsToRemove);
$result = $stmt->fetch();

if ($result['count'] == 0) {
    echo "✓ All products successfully removed from database" . PHP_EOL;
} else {
    echo "⚠ Warning: " . $result['count'] . " product(s) still remain in database" . PHP_EOL;
}

echo PHP_EOL . "Done!" . PHP_EOL;
?>

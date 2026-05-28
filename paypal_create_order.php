<?php
// paypal_create_order.php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Cart empty or not logged in']);
    exit;
}

// Calculate total
$total = 0;
$ids = array_keys($_SESSION['cart']);
$placeholders = str_repeat('?,', count($ids) - 1) . '?';
$stmt = $pdo->prepare("SELECT price FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);
$products = $stmt->fetchAll();

foreach ($products as $p) {
    // Note: PayPal expects prices in USD usually. 
    // If your site is in Dinar, you might need a conversion factor.
    // Here we'll assume the site works in a compatible currency for testing (e.g. USD)
    // or we just send the number even if it's large.
    $total += $p['price'] * $_SESSION['cart'][$ids[array_search($p, $products)]]; 
    // Wait, the above logic for total is slightly safer with product ID matching
}

// Safer total recalculation
$total = 0;
$stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);
$db_products = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
foreach ($_SESSION['cart'] as $id => $qty) {
    if (isset($db_products[$id])) {
        $total += $db_products[$id] * $qty;
    }
}

// 1. Get Access Token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, PAYPAL_API_URL . '/v1/oauth2/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ':' . PAYPAL_CLIENT_SECRET);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Accept-Language: en_US']);

$result = curl_exec($ch);
$accessToken = json_decode($result)->access_token;
curl_close($ch);

// 2. Create Order
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, PAYPAL_API_URL . '/v2/checkout/orders');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
]);

$orderData = [
    'intent' => 'CAPTURE',
    'purchase_units' => [[
        'amount' => [
            'currency_code' => 'USD', // Adjust to DA if supported or convert
            'value' => number_format($total, 2, '.', '')
        ]
    ]]
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200 || $httpCode === 201) {
    echo $result;
} else {
    http_response_code($httpCode);
    echo $result;
}
?>

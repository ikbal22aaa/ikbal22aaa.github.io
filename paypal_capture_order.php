<?php
// paypal_capture_order.php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$paypalOrderID = $data['orderID'] ?? null;

if (!$paypalOrderID) {
    http_response_code(400);
    exit;
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

// 2. Capture Order
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, PAYPAL_API_URL . "/v2/checkout/orders/$paypalOrderID/capture");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
]);

$result = curl_exec($ch);
$captureData = json_decode($result, true);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200 || $httpCode === 201) {
    if ($captureData['status'] === 'COMPLETED') {
        // Success! Create the order in fixed DB
        try {
            $pdo->beginTransaction();

            // Fetch total and cart products again (security)
            $ids = array_keys($_SESSION['cart']);
            $placeholders = str_repeat('?,', count($ids) - 1) . '?';
            $stmt = $pdo->prepare("SELECT id, price, stock_quantity, name FROM products WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $products = $stmt->fetchAll(PDO::FETCH_UNIQUE);

            $total = 0;
            foreach ($_SESSION['cart'] as $id => $qty) {
                if (isset($products[$id])) {
                    $total += $products[$id]['price'] * $qty;
                }
            }

            // Get shipping address from session or another source if needed
            // For now we might need to store it temporarily during checkout or pass it here
            $shipping_address = $data['shipping_address'] ?? 'PayPal Checkout';

            // 1. Create Order
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, status, payment_method, paypal_order_id, shipping_address) VALUES (?, ?, 'payee', 'paypal', ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $total, $paypalOrderID, $shipping_address]);
            $order_id = $pdo->lastInsertId();

            // 2. Items & Stock
            foreach ($_SESSION['cart'] as $id => $qty) {
                if (isset($products[$id])) {
                    $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                    $stmtItem->execute([$order_id, $id, $qty, $products[$id]['price']]);
                    
                    $stmtStock = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
                    $stmtStock->execute([$qty, $id]);
                }
            }

            $pdo->commit();
            unset($_SESSION['cart']);
            
            echo json_encode(['status' => 'success', 'order_id' => $order_id]);
        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Payment not completed', 'details' => $captureData]);
    }
} else {
    http_response_code($httpCode);
    echo $result;
}
?>

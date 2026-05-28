<?php
// checkout.php
require 'includes/header.php';
require 'auth.php'; // ensure logged in check functions are available

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Fetch user data for pre-fill
$user = getCurrentUser($pdo);

// Calculate Total
$total = 0;
$ids = array_keys($_SESSION['cart']);
$placeholders = str_repeat('?,', count($ids) - 1) . '?';
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);
$products = $stmt->fetchAll();

foreach ($products as $p) {
    $total += $p['price'] * $_SESSION['cart'][$p['id']];
}

// Handle Order Placement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'];
    $payment_method = 'cod'; // Payment on delivery

    try {
        $pdo->beginTransaction();

        // 1. Create Order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, status, payment_method, shipping_address) VALUES (?, ?, 'en_attente', ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $total, $payment_method, $address]);
        $order_id = $pdo->lastInsertId();

        // 2. Create Order Items & Update Stock
        $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmtUpdateStock = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");

        foreach ($products as $p) {
            $qty = $_SESSION['cart'][$p['id']];
            
            // Check stock again
            if ($p['stock_quantity'] < $qty) {
                throw new Exception("Stock insuffisant pour " . $p['name']);
            }

            $stmtItem->execute([$order_id, $p['id'], $qty, $p['price']]);
            $stmtUpdateStock->execute([$qty, $p['id']]);
        }

        $pdo->commit();
        
        // Clear Cart
        unset($_SESSION['cart']);
        
        header('Location: thank_you.php?order=' . $order_id);
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Erreur: " . $e->getMessage();
    }
}
?>

<div class="container" style="margin-top: 3rem;">
    <h1>Validation de la commande</h1>
    
    <?php if (isset($error)): ?>
        <div style="background: #fee2e2; color: #ef4444; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
        <!-- Form -->
        <div style="flex: 2; min-width: 300px;">
            <div class="card" style="padding: 2rem;">
                <form method="POST">
                    <h3 style="margin-bottom: 1.5rem;">Informations de livraison</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Nom complet</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                        <p style="font-size: 0.8rem; color: #64748b;">Le nom de votre compte sera utilisé.</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Adresse de livraison</label>
                        <textarea name="address" class="form-control" rows="3" required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group" style="margin-top: 2rem;">
                        <label class="form-label">Mode de paiement</label>
                        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                            <label style="flex: 1; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;" id="label-cod">
                                <input type="radio" name="payment_method" value="cod" checked onchange="togglePayment('cod')">
                                <div>
                                    <span style="font-weight: 600; display: block;">Paiement à la livraison</span>
                                    <span style="font-size: 0.8rem; color: #64748b;">Payez en espèces à la réception.</span>
                                </div>
                            </label>
                            <label style="flex: 1; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;" id="label-paypal">
                                <input type="radio" name="payment_method" value="paypal" onchange="togglePayment('paypal')">
                                <div>
                                    <span style="font-weight: 600; display: block;">PayPal</span>
                                    <span style="font-size: 0.8rem; color: #64748b;">Paiement sécurisé en ligne.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="cod-container">
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem;">Confirmer la commande (COD)</button>
                    </div>

                    <div id="paypal-button-container" style="display: none; margin-top: 1rem;"></div>
                </form>
            </div>
        </div>

        <script src="https://www.paypal.com/sdk/js?client-id=<?= PAYPAL_CLIENT_ID ?>&currency=USD"></script>
        <script>
        function togglePayment(method) {
            document.getElementById('cod-container').style.display = method === 'cod' ? 'block' : 'none';
            document.getElementById('paypal-button-container').style.display = method === 'paypal' ? 'block' : 'none';
            
            // Highlight selected
            document.getElementById('label-cod').style.borderColor = method === 'cod' ? 'var(--primary-color)' : '#e2e8f0';
            document.getElementById('label-paypal').style.borderColor = method === 'paypal' ? 'var(--primary-color)' : '#e2e8f0';
        }

        // Initialize view
        togglePayment('cod');

        paypal.Buttons({
            createOrder: function() {
                return fetch('paypal_create_order.php', {
                    method: 'POST'
                }).then(function(res) {
                    return res.json();
                }).then(function(data) {
                    return data.id;
                });
            },
            onApprove: function(data) {
                const address = document.querySelector('textarea[name="address"]').value;
                return fetch('paypal_capture_order.php', {
                    method: 'POST',
                    headers: { 'content-type': 'application/json' },
                    body: JSON.stringify({
                        orderID: data.orderID,
                        shipping_address: address
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(details) {
                    if (details.status === 'success') {
                        window.location.href = 'thank_you.php?order=' + details.order_id;
                    } else {
                        alert('Erreur lors de la capture du paiement : ' + (details.error || 'Erreur inconnue'));
                    }
                });
            }
        }).render('#paypal-button-container');
        </script>

        <!-- Summary Side -->
        <div style="flex: 1; min-width: 250px;">
            <div class="card" style="padding: 1.5rem;">
                <h3>Vos articles</h3>
                <ul style="margin-top: 1rem; border-top: 1px solid #e2e8f0; padding-top: 1rem;">
                    <?php foreach ($products as $p): ?>
                        <li style="display: flex; justify-content: space-between; margin-bottom: 0.8rem;">
                            <span><?= $_SESSION['cart'][$p['id']] ?>x <?= htmlspecialchars($p['name']) ?></span>
                            <span><?= number_format($p['price'] * $_SESSION['cart'][$p['id']], 0) ?> DA</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div style="border-top: 1px solid #e2e8f0; margin-top: 1rem; padding-top: 1rem; display: flex; justify-content: space-between; font-weight: 700; font-size: 1.2rem;">
                    <span>Total</span>
                    <span style="color: var(--accent-color);"><?= number_format($total, 2) ?> DA</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'includes/footer.php'; ?>
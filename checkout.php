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

                    <h3 style="margin: 2rem 0 1rem;">Paiement</h3>
                    <div style="padding: 1rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; background: #f8fafc; display: flex; align-items: center; gap: 1rem;">
                        <input type="radio" checked disabled>
                        <div>
                            <span style="font-weight: 600;">Paiement à la livraison</span>
                            <p style="font-size: 0.9rem; color: #64748b;">Payez en espèces lorsque vous recevez votre commande.</p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 2rem; padding: 1rem; font-size: 1.1rem;">Confirmer la commande</button>
                </form>
            </div>
        </div>

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
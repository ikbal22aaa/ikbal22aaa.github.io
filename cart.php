<?php
// cart.php
require 'includes/header.php';

$cartItems = $_SESSION['cart'] ?? [];
$products = [];
$total = 0;

if (!empty($cartItems)) {
    // Generate placeholders for IN clause
    $placeholders = str_repeat('?,', count($cartItems) - 1) . '?';
    $ids = array_keys($cartItems);
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();
}
?>
<div class="container" style="margin-top: 3rem;">
    <h1>Mon Panier</h1>

    <?php if (empty($products)): ?>
        <div class="card" style="padding: 3rem; text-align: center;">
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">Votre panier est vide.</p>
            <a href="shop.php" class="btn btn-primary">Retourner à la boutique</a>
        </div>
    <?php else: ?>
        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
            <!-- Cart Items -->
            <div style="flex: 2; min-width: 300px;">
                <div class="card" style="overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                <th style="padding: 1rem; text-align: left;">Produit</th>
                                <th style="padding: 1rem; text-align: center;">Prix</th>
                                <th style="padding: 1rem; text-align: center;">Quantité</th>
                                <th style="padding: 1rem; text-align: right;">Total</th>
                                <th style="padding: 1rem;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $p): 
                                $qty = $cartItems[$p['id']];
                                $lineTotal = $p['price'] * $qty;
                                $total += $lineTotal;
                            ?>
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 1rem; display: flex; align-items: center; gap: 1rem;">
                                    <?php if($p['image_url']): ?>
                                        <img src="<?= htmlspecialchars($p['image_url']) ?>" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                                    <?php endif; ?>
                                    <span style="font-weight: 500;"><?= htmlspecialchars($p['name']) ?></span>
                                </td>
                                <td style="padding: 1rem; text-align: center;"><?= number_format($p['price'], 0) ?> DA</td>
                                <td style="padding: 1rem; text-align: center;">
                                    <form action="cart_actions.php" method="POST" style="display: inline-flex; align-items: center; gap: 5px;">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                        <input type="number" name="quantity" value="<?= $qty ?>" min="1" max="<?= $p['stock_quantity'] ?>" style="width: 50px; padding: 5px; border: 1px solid #cbd5e1; border-radius: 4px;">
                                        <button type="submit" class="btn btn-outline" style="padding: 2px 6px; font-size: 0.8rem;"><i class="fas fa-sync"></i></button>
                                    </form>
                                </td>
                                <td style="padding: 1rem; text-align: right; font-weight: 600;"><?= number_format($lineTotal, 0) ?> DA</td>
                                <td style="padding: 1rem; text-align: center;">
                                    <a href="cart_actions.php?action=remove&id=<?= $p['id'] ?>" style="color: #ef4444;"><i class="fas fa-trash"></i> X</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary -->
            <div style="flex: 1; min-width: 250px;">
                <div class="card" style="padding: 1.5rem;">
                    <h3>Récapitulatif</h3>
                    <div style="display: flex; justify-content: space-between; margin: 1.5rem 0; font-size: 1.2rem; font-weight: 700;">
                        <span>Total:</span>
                        <span style="color: var(--accent-color);"><?= number_format($total, 2) ?> DA</span>
                    </div>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="checkout.php" class="btn btn-primary" style="width: 100%; text-align: center; display: block;">Commander</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary" style="width: 100%; text-align: center; display: block;">Se connecter pour commander</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require 'includes/footer.php'; ?>
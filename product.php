<?php
// product.php
require 'includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: shop.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "<div class='container' style='margin-top:2rem;'>Produit introuvable.</div>";
    require 'includes/footer.php';
    exit;
}
?>

<div class="container" style="margin-top: 3rem;">
    <div class="card" style="display: flex; flex-direction: row; overflow: hidden; min-height: 400px; max-width: 900px; margin: 0 auto;">
        <!-- Image -->
        <div style="flex: 1; background: #f8fafc; min-width: 300px;">
            <?php if($product['image_url']): ?>
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
            <?php else: ?>
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">No Image</div>
            <?php endif; ?>
        </div>
        
        <!-- Details -->
        <div style="flex: 1; padding: 2rem; display: flex; flex-direction: column;">
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($product['name']) ?></h1>
            <p style="font-size: 1.5rem; color: var(--accent-color); font-weight: 700; margin-bottom: 1.5rem;">
                <?= number_format($product['price'], 2) ?> DA
            </p>
            
            <p style="color: #64748b; margin-bottom: 2rem; line-height: 1.8;">
                <?= nl2br(htmlspecialchars($product['description'])) ?>
            </p>

            <div style="margin-top: auto;">
                <?php if ($product['stock_quantity'] > 0): ?>
                    <form action="cart_actions.php" method="POST" style="display: flex; gap: 1rem; align-items: center;">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" class="form-control" style="width: 80px;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">Ajouter au panier</button>
                    </form>
                    <p style="color: var(--success); font-size: 0.9rem; margin-top: 0.5rem;">
                        <i class="fas fa-check-circle"></i> En stock (<?= $product['stock_quantity'] ?> restants)
                    </p>
                <?php else: ?>
                    <button disabled class="btn btn-outline" style="width: 100%; cursor: not-allowed; opacity: 0.6;">Rupture de stock</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>

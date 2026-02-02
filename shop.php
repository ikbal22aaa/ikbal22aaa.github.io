<?php
// shop.php
require 'includes/header.php';

$category_id = $_GET['category'] ?? null;
$search = $_GET['search'] ?? null;

// Build Query
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($category_id) {
    $sql .= " AND category_id = ?";
    $params[] = $category_id;
}

if ($search) {
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Fetch all categories for sidebar
$cats = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<div class="container" style="margin-top: 3rem; display: flex; gap: 2rem;">
    <!-- Sidebar -->
    <aside style="width: 250px; flex-shrink: 0;">
        <div class="card" style="padding: 1.5rem;">
            <h3>Catégories</h3>
            <ul style="margin-top: 1rem;">
                <li><a href="shop.php" style="<?= !$category_id ? 'color: var(--accent-color); font-weight: 700;' : '' ?>">Tout voir</a></li>
                <?php foreach ($cats as $c): ?>
                    <li>
                        <a href="?category=<?= $c['id'] ?>" style="<?= $category_id == $c['id'] ? 'color: var(--accent-color); font-weight: 700;' : '' ?>">
                            <?= htmlspecialchars($c['name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>

    <!-- Product Grid -->
    <main style="flex: 1;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2>Boutique</h2>
            <form style="display: flex; gap: 0.5rem;">
                <input type="text" name="search" placeholder="Rechercher..." class="form-control" value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit" class="btn btn-primary">Ok</button>
            </form>
        </div>

        <?php if (count($products) > 0): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem;">
                <?php foreach ($products as $p): ?>
                    <div class="card">
                        <div style="height: 200px; overflow: hidden; background: #f1f5f9; position: relative;">
                            <?php if($p['image_url']): ?>
                                <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">No Image</div>
                            <?php endif; ?>
                            <?php if($p['stock_quantity'] <= 0): ?>
                                <div style="position: absolute; top: 0; left: 0; background: #ef4444; color: #fff; padding: 2px 8px; font-size: 0.8rem;">Épuisé</div>
                            <?php endif; ?>
                        </div>
                        <div style="padding: 1rem;">
                            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($p['name']) ?></h3>
                            <p style="color: var(--accent-color); font-weight: 700; margin-bottom: 1rem;"><?= number_format($p['price'], 2) ?> DA</p>
                            <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-outline" style="width: 100%; text-align: center; display: block;">Voir Détails</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun produit trouvé.</p>
        <?php endif; ?>
    </main>
</div>

<?php require 'includes/footer.php'; ?>

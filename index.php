<?php
// index.php
require 'includes/header.php';

// Fetch featured products (limit 4)
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 4");
$featured = $stmt->fetchAll();

// Fetch categories
$cats = $pdo->query("SELECT * FROM categories ORDER BY id ASC")->fetchAll();
?>

<!-- Hero Section -->
<header style="background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('assets/images/hero_bg.jpg') no-repeat center center/cover; height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; color: #fff;">
    <div class="container">
        <h1 style="font-size: 3.5rem; color: #fff; margin-bottom: 1rem;">Votre Boutique en Ligne</h1>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">Des milliers de produits pour tous les budgets. Livraison partout en Algérie.</p>
        <a href="shop.php" class="btn btn-accent" style="padding: 1rem 2rem; font-size: 1.1rem;">Découvrir nos produits</a>
    </div>
</header>

<!-- Categories -->
<section class="container" style="margin-top: 4rem;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Nos Catégories</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <?php foreach ($cats as $c): ?>
            <div class="card" style="position: relative; height: 250px; display: flex; align-items: center; justify-content: center; text-align: center; background: #e2e8f0;">
                <!-- Placeholder background if no image -->
                <?php if($c['image_url']): ?>
                    <img src="<?= htmlspecialchars($c['image_url']) ?>" alt="<?= htmlspecialchars($c['name']) ?>" style="position: absolute; width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6);">
                <?php endif; ?>
                <div style="position: relative; z-index: 1;">
                    <h3 style="color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.5); font-size: 2rem;"><?= htmlspecialchars($c['name']) ?></h3>
                </div>
                <a href="shop.php?category=<?= $c['id'] ?>" style="position: absolute; inset: 0;"></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Featured Products -->
<section class="container" style="margin-top: 4rem;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Nouveautés</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 2rem;">
        <?php foreach ($featured as $p): ?>
            <div class="card">
                <div style="height: 250px; overflow: hidden; background: #f1f5f9;">
                    <?php if($p['image_url']): ?>
                        <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">No Image</div>
                    <?php endif; ?>
                </div>
                <div style="padding: 1.5rem;">
                    <h3 style="font-size: 1.2rem;"><?= htmlspecialchars($p['name']) ?></h3>
                    <p style="color: var(--accent-color); font-weight: 700; font-size: 1.1rem; margin: 0.5rem 0;"><?= number_format($p['price'], 2) ?> DA</p>
                    <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-outline" style="width: 100%; text-align: center; margin-top: 0.5rem;">Voir Détails</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div style="text-align: center; margin-top: 2rem;">
        <a href="shop.php" class="btn btn-primary">Voir tout les produits</a>
    </div>
</section>
<?php require 'includes/footer.php'; ?>
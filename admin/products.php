<?php
// admin/products.php
session_start();
require '../config.php';
require '../auth.php';
requireAdmin();

// Suppression
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: products.php');
    exit;
}

$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Produits</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--primary-color); color: #fff; padding: 2rem; }
        .sidebar a { display: block; padding: 10px; color: #cbd5e1; margin-bottom: 5px; border-radius: 5px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: #fff; }
        .content { flex: 1; padding: 2rem; background: #f1f5f9; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #f8fafc; font-weight: 600; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <div class="sidebar">
            <h2 style="color: #fff; margin-bottom: 2rem;">Admin Panel</h2>
            <a href="dashboard.php">Tableau de bord</a>
            <a href="products.php" class="active">Produits</a>
            <a href="categories.php">Catégories</a>
            <a href="orders.php">Commandes</a>
            <a href="../index.php" style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">Voir le site</a>
        </div>
        <div class="content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1>Produits</h1>
                <a href="product_form.php" class="btn btn-primary">Ajouter un produit</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix (DA)</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td>
                            <?php if($p['image_url']): ?>
                                <img src="../<?= htmlspecialchars($p['image_url']) ?>" alt="img" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            <?php else: ?>
                                <span style="color: #ccc;">No img</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['category_name']) ?></td>
                        <td><?= number_format($p['price'], 2) ?> DA</td>
                        <td><?= $p['stock_quantity'] ?></td>
                        <td>
                            <a href="product_form.php?id=<?= $p['id'] ?>" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Modifier</a>
                            <a href="?delete=<?= $p['id'] ?>" class="btn btn-danger" onclick="return confirm('Supprimer ?')" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; background: #ef4444; color: #fff;">Suppr</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

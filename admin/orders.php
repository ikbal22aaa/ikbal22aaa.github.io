<?php
// admin/orders.php
session_start();
require '../config.php';
require '../auth.php';
requireAdmin();

$orders = $pdo->query("
    SELECT o.*, u.username 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commandes</title>
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
    </style>
</head>
<body>
    <div class="admin-layout">
        <div class="sidebar">
            <h2 style="color: #fff; margin-bottom: 2rem;">Admin Panel</h2>
            <a href="dashboard.php">Tableau de bord</a>
            <a href="products.php">Produits</a>
            <a href="categories.php">Catégories</a>
            <a href="orders.php" class="active">Commandes</a>
            <a href="../index.php" style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">Voir le site</a>
        </div>
        <div class="content">
            <h1>Commandes</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Adresse</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                    <tr>
                        <td>#<?= $o['id'] ?></td>
                        <td><?= htmlspecialchars($o['username']) ?></td>
                        <td><?= number_format($o['total_price'], 2) ?> DA</td>
                        <td>
                            <span style="padding: 2px 8px; border-radius: 4px; background: #e2e8f0; font-size: 0.85rem;">
                                <?= htmlspecialchars($o['status']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars(substr($o['shipping_address'], 0, 30)) ?>...</td>
                        <td><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

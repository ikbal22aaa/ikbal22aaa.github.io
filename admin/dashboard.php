<?php
// admin/dashboard.php
session_start();
require '../config.php';

// Vérification admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Stats rapides
$stmt = $pdo->query("SELECT count(*) FROM orders");
$orderCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT count(*) FROM products");
$productCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT count(*) FROM users");
$userCount = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--primary-color); color: #fff; padding: 2rem; }
        .sidebar a { display: block; padding: 10px; color: #cbd5e1; margin-bottom: 5px; border-radius: 5px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: #fff; }
        .content { flex: 1; padding: 2rem; background: #f1f5f9; }
        .stat-card { background: #fff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <div class="sidebar">
            <h2 style="color: #fff; margin-bottom: 2rem;">Admin Panel</h2>
            <a href="dashboard.php" class="active">Tableau de bord</a>
            <a href="products.php">Produits</a>
            <a href="categories.php">Catégories</a>
            <a href="orders.php">Commandes</a>
            <a href="../index.php" style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">Voir le site</a>
            <a href="../logout.php">Déconnexion</a>
        </div>
        <div class="content">
            <h1>Tableau de bord</h1>
            <div class="grid">
                <div class="stat-card">
                    <h3>Commandes</h3>
                    <p style="font-size: 2rem; font-weight: 700; color: var(--accent-color);"><?= $orderCount ?></p>
                </div>
                <div class="stat-card">
                    <h3>Produits</h3>
                    <p style="font-size: 2rem; font-weight: 700; color: var(--primary-color);"><?= $productCount ?></p>
                </div>
                <div class="stat-card">
                    <h3>Utilisateurs</h3>
                    <p style="font-size: 2rem; font-weight: 700; color: var(--success);"><?= $userCount ?></p>
                </div>
            </div>
            
            <div class="card" style="margin-top: 2rem; padding: 1.5rem;">
                <h3>Dernières commandes</h3>
                <p>Aucune commande récente.</p>
            </div>
        </div>
    </div>
</body>
</html>

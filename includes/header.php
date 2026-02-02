<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config.php'; // Ajustement du chemin si nécessaire
// Si config déjà inclus, require_once évite l'erreur.

// Calcul du nombre d'articles dans le panier
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty) {
        $cartCount += $qty;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop - Boutique en Ligne</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Pour les icônes si besoin, sinon texte -->
</head>
<body>
    <nav class="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <span style="color: var(--accent-color);">E</span>-SHOP
            </a>
            
            <div class="nav-links">
                <a href="index.php">Accueil</a>
                <a href="shop.php">Boutique</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="admin/dashboard.php">Admin</a>
                <?php endif; ?>
            </div>

            <div class="nav-icons">
                <a href="cart.php" style="position: relative; font-size: 1.1rem;">
                    Panier
                    <?php if ($cartCount > 0): ?>
                        <span style="position: absolute; top: -8px; right: -12px; background: var(--accent-color); color: #fff; font-size: 0.7rem; padding: 2px 6px; border-radius: 50%;"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="btn btn-outline" style="padding: 0.5rem 1rem;">Déconnexion</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary" style="padding: 0.5rem 1rem;">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

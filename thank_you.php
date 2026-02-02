<?php
// thank_you.php
require 'includes/header.php';
$order_id = $_GET['order'] ?? '';
?>

<div class="container" style="margin-top: 5rem; text-align: center;">
    <div class="card" style="padding: 4rem; max-width: 600px; margin: 0 auto;">
        <div style="color: var(--success); font-size: 4rem; margin-bottom: 2rem;">
            <i class="fas fa-check-circle"></i> <!-- FontAwesome handled if present, or just text -->
            &#10004; <!-- Fallback unicode checkmark -->
        </div>
        <h1>Merci pour votre commande !</h1>
        <p style="font-size: 1.2rem; margin: 1rem 0;">Votre commande #<?= htmlspecialchars($order_id) ?> a été enregistrée avec succès.</p>
        <p style="color: #64748b;">Vous recevrez vos articles bientôt. Le paiement se fera à la livraison.</p>
        
        <div style="margin-top: 3rem;">
            <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
            <a href="shop.php" class="btn btn-outline" style="margin-left: 1rem;">Continuer le shopping</a>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>

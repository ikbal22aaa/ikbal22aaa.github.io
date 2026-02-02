<?php
// register.php
require 'auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Créer le compte
            $info_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, address, phone) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$username, $email, $info_hash, $address, $phone])) {
                $_SESSION['success'] = "Compte créé ! Connectez-vous maintenant.";
                header('Location: login.php');
                exit;
            } else {
                $error = "Une erreur est survenue.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - E-Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background-color: #f1f5f9; padding: 20px;">

    <div class="card" style="width: 100%; max-width: 500px; padding: 2rem;">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Créer un compte</h2>
        
        <?php if ($error): ?>
            <div style="background-color: #fee2e2; color: #ef4444; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label class="form-label">Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Téléphone</label>
                <input type="text" name="phone" class="form-control" placeholder="05 55 ..." required>
            </div>
            <div class="form-group">
                <label class="form-label">Adresse de livraison</label>
                <textarea name="address" class="form-control" rows="2" required></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">S'inscrire</button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
            Déjà un compte ? <a href="login.php" style="color: var(--accent-color); font-weight: 600;">Se connecter</a>
        </p>
    </div>

</body>
</html>

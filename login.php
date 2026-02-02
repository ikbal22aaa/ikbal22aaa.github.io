<?php
// login.php
require 'auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        if ($user['role'] === 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - E-Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background-color: #f1f5f9;">

    <div class="card" style="width: 100%; max-width: 400px; padding: 2rem;">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Bienvenue</h2>
        
        <?php if ($error): ?>
            <div style="background-color: #fee2e2; color: #ef4444; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Se connecter</button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
            Pas encore de compte ? <a href="register.php" style="color: var(--accent-color); font-weight: 600;">S'inscrire</a>
        </p>
    </div>

</body>
</html>

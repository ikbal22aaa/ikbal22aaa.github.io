<?php
// create_admin.php
require 'config.php';

$email = 'admin@shop.com';
$password = 'admin123';
$hashed = password_hash($password, PASSWORD_DEFAULT);

try {
    // Delete existing admin if exists
    $stmt = $pdo->prepare("DELETE FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    // Create new admin
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Admin', $email, $hashed, 'admin']);
    
    echo "Compte admin créé avec succès !<br>";
    echo "Email: admin@shop.com<br>";
    echo "Mot de passe: admin123<br>";
    echo "<br>Vous pouvez maintenant vous connecter.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
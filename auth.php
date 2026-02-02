<?php
// auth.php
session_start();
require 'config.php';

// Fonction pour vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fonction pour vérifier si l'utilisateur est admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Rediriger si non connecté
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Rediriger si non admin
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: index.php');
        exit;
    }
}

// Récupérer les infos de l'utilisateur courant
function getCurrentUser($pdo) {
    if (isLoggedIn()) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
    return null;
}
?>

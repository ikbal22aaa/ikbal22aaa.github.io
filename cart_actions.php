<?php
// cart_actions.php
require 'auth.php';

// Initialiser le panier si nécessaire
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Retrieve params from GET or POST
$action = $_REQUEST['action'] ?? '';
$product_id = $_REQUEST['product_id'] ?? ($_REQUEST['id'] ?? null);
$quantity = (int)($_REQUEST['quantity'] ?? 1);

if ($action === 'add' && $product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    header('Location: cart.php');
    exit;
}

if ($action === 'remove' && $product_id) {
    unset($_SESSION['cart'][$product_id]);
    header('Location: cart.php');
    exit;
}

if ($action === 'update' && $product_id) {
    if ($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
    header('Location: cart.php');
    exit;
}

if ($action === 'clear') {
    $_SESSION['cart'] = [];
    header('Location: cart.php');
    exit;
}

// Fallback redirect
header('Location: shop.php');
exit;
?>

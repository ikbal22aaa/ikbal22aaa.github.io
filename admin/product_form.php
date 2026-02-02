<?php
// admin/product_form.php
session_start();
require '../config.php';
require '../auth.php';
requireAdmin();

$product = [
    'id' => '', 'name' => '', 'description' => '', 'price' => '', 
    'stock_quantity' => '', 'category_id' => '', 'image_url' => ''
];
$title = "Ajouter un produit";

if (isset($_GET['id'])) {
    $title = "Modifier le produit";
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
}

// Fetch categories
$cats = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock_quantity'];
    $category_id = $_POST['category_id'];
    $image_url = $product['image_url'];

    // Upload Image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "../assets/images/products/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = "assets/images/products/" . $filename;
        }
    }

    if ($product['id']) {
        // Update
        $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, stock_quantity=?, category_id=?, image_url=? WHERE id=?");
        $stmt->execute([$name, $description, $price, $stock, $category_id, $image_url, $product['id']]);
    } else {
        // Insert
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock_quantity, category_id, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $stock, $category_id, $image_url]);
    }
    header('Location: products.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background: #f1f5f9; padding: 2rem;">
    <div class="card" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
        <h2 style="margin-bottom: 2rem;"><?= $title ?></h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Catégorie</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Choisir une catégorie</option>
                    <?php foreach ($cats as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Prix (DA)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($product['price']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock_quantity" class="form-control" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
                <?php if($product['image_url']): ?>
                    <p style="margin-top: 0.5rem;">Actuelle: <img src="../<?= $product['image_url'] ?>" width="50"></p>
                <?php endif; ?>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Enregistrer</button>
                <a href="products.php" class="btn btn-outline" style="flex: 1; text-align: center;">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>

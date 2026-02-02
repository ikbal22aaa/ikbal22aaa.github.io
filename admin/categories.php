<?php
// admin/categories.php
session_start();
require '../config.php';
require '../auth.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $image_url = '';

    // Upload Image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "../assets/images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = "assets/images/" . $filename;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO categories (name, description, image_url) VALUES (?, ?, ?)");
    $stmt->execute([$name, $desc, $image_url]);
    header('Location: categories.php');
    exit;
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: categories.php');
    exit;
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Catégories</title>
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
            <a href="categories.php" class="active">Catégories</a>
            <a href="orders.php">Commandes</a>
            <a href="../index.php" style="margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">Voir le site</a>
        </div>
        <div class="content">
            <h1>Catégories</h1>
            
            <div class="card" style="padding: 1.5rem; margin-bottom: 2rem; max-width: 500px;">
                <h3>Ajouter une catégorie</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <textarea name="description" placeholder="Description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Image de la catégorie</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $c): ?>
                    <tr>
                        <td>
                            <?php if($c['image_url']): ?>
                                <img src="../<?= htmlspecialchars($c['image_url']) ?>" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                            <?php else: ?>
                                <span style="color: #ccc;">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td><?= htmlspecialchars($c['description']) ?></td>
                        <td>
                            <a href="?delete=<?= $c['id'] ?>" class="btn btn-danger" style="background: #ef4444; color: #fff; padding: 5px 10px; font-size: 0.8rem;" onclick="return confirm('Supprimer ?')">Suppr</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

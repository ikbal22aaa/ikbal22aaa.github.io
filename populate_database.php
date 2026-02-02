<?php
// populate_database.php
require 'config.php';

try {
    // Clear existing data
    $pdo->exec("DELETE FROM order_items");
    $pdo->exec("DELETE FROM orders");
    $pdo->exec("DELETE FROM products");
    $pdo->exec("DELETE FROM categories WHERE id > 0");
    
    echo "✓ Données existantes supprimées<br><br>";
    
    // Insert Categories
    $categories = [
        ['Électronique', 'Smartphones, ordinateurs, accessoires high-tech', 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=800'],
        ['Mode & Vêtements', 'Vêtements pour homme, femme et enfant', 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=800'],
        ['Maison & Décoration', 'Meubles, décoration et accessoires pour la maison', 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800'],
        ['Sports & Loisirs', 'Équipements sportifs et articles de loisirs', 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800'],
        ['Beauté & Santé', 'Produits de beauté, cosmétiques et bien-être', 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO categories (name, description, image_url) VALUES (?, ?, ?)");
    foreach ($categories as $cat) {
        $stmt->execute($cat);
    }
    
    echo "✓ 5 catégories ajoutées<br><br>";
    
    // Get category IDs
    $catIds = [];
    $result = $pdo->query("SELECT id, name FROM categories");
    while ($row = $result->fetch()) {
        $catIds[$row['name']] = $row['id'];
    }
    
    // Products data
    $products = [
        // Électronique (10)
        [$catIds['Électronique'], 'iPhone 15 Pro', 'Smartphone Apple dernière génération avec puce A17', 180000, 12, 'https://images.unsplash.com/photo-1696446702183-cbd50c78becc?w=500'],
        [$catIds['Électronique'], 'Samsung Galaxy S24', 'Flagship Samsung avec écran AMOLED 120Hz', 145000, 18, 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=500'],
        [$catIds['Électronique'], 'MacBook Air M3', 'Ordinateur portable ultra-léger et puissant', 220000, 8, 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500'],
        [$catIds['Électronique'], 'iPad Pro 12.9"', 'Tablette professionnelle avec stylet Apple Pencil', 165000, 10, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=500'],
        [$catIds['Électronique'], 'AirPods Pro 2', 'Écouteurs sans fil avec réduction de bruit', 35000, 25, 'https://images.unsplash.com/photo-1606841837239-c5a1a4a07af7?w=500'],
        [$catIds['Électronique'], 'Sony WH-1000XM5', 'Casque audio premium avec ANC', 48000, 15, 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=500'],
        [$catIds['Électronique'], 'Apple Watch Series 9', 'Montre connectée avec suivi santé avancé', 75000, 20, 'https://images.unsplash.com/photo-1434494878577-86c23bcb06b9?w=500'],
        [$catIds['Électronique'], 'Canon EOS R6', 'Appareil photo hybride professionnel', 385000, 5, 'https://images.unsplash.com/photo-1606980707123-ccb8a0e3e0b5?w=500'],
        [$catIds['Électronique'], 'PlayStation 5', 'Console de jeu nouvelle génération', 95000, 7, 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=500'],
        [$catIds['Électronique'], 'Logitech MX Master 3', 'Souris ergonomique sans fil', 15500, 30, 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500'],
        
        // Mode & Vêtements (10)
        [$catIds['Mode & Vêtements'], 'Chemise Homme Blanche', 'Chemise en coton premium coupe slim', 4500, 40, 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500'],
        [$catIds['Mode & Vêtements'], 'Jean Slim Noir', 'Jean stretch confortable pour homme', 6800, 35, 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500'],
        [$catIds['Mode & Vêtements'], 'Robe d\'été Fleurie', 'Robe légère pour femme motif floral', 5200, 28, 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=500'],
        [$catIds['Mode & Vêtements'], 'Veste en Cuir', 'Veste cuir véritable style biker', 18500, 12, 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500'],
        [$catIds['Mode & Vêtements'], 'Sneakers Nike Air Max', 'Chaussures de sport confortables', 12000, 22, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500'],
        [$catIds['Mode & Vêtements'], 'Sac à Main Cuir', 'Sac élégant en cuir pour femme', 9500, 18, 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=500'],
        [$catIds['Mode & Vêtements'], 'Montre Classique', 'Montre analogique élégante', 8200, 25, 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=500'],
        [$catIds['Mode & Vêtements'], 'Lunettes de Soleil', 'Lunettes UV protection style aviateur', 3500, 45, 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500'],
        [$catIds['Mode & Vêtements'], 'Écharpe en Laine', 'Écharpe douce et chaude pour hiver', 2800, 50, 'https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?w=500'],
        [$catIds['Mode & Vêtements'], 'Ceinture en Cuir', 'Ceinture classique réversible', 3200, 38, 'https://images.unsplash.com/photo-1624222247344-550fb60583bb?w=500'],
        
        // Maison & Décoration (10)
        [$catIds['Maison & Décoration'], 'Canapé 3 Places Gris', 'Canapé confortable en tissu moderne', 65000, 8, 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500'],
        [$catIds['Maison & Décoration'], 'Table Basse Bois', 'Table basse design en bois massif', 18500, 12, 'https://images.unsplash.com/photo-1532372320572-cda25653a26d?w=500'],
        [$catIds['Maison & Décoration'], 'Lampe LED Design', 'Lampe de salon moderne avec variateur', 7800, 25, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500'],
        [$catIds['Maison & Décoration'], 'Tapis Berbère 200x300', 'Tapis traditionnel fait main', 22000, 6, 'https://images.unsplash.com/photo-1600166898405-da9535204843?w=500'],
        [$catIds['Maison & Décoration'], 'Miroir Mural Rond', 'Miroir décoratif cadre doré', 5500, 20, 'https://images.unsplash.com/photo-1618220179428-22790b461013?w=500'],
        [$catIds['Maison & Décoration'], 'Coussin Décoratif Set', 'Lot de 4 coussins assortis', 4200, 30, 'https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?w=500'],
        [$catIds['Maison & Décoration'], 'Vase Céramique', 'Vase artisanal pour fleurs', 3800, 35, 'https://images.unsplash.com/photo-1578500494198-246f612d3b3d?w=500'],
        [$catIds['Maison & Décoration'], 'Horloge Murale', 'Horloge silencieuse design minimaliste', 4500, 28, 'https://images.unsplash.com/photo-1563861826100-9cb868fdbe1c?w=500'],
        [$catIds['Maison & Décoration'], 'Rideau Occultant', 'Paire de rideaux isolants thermiques', 6200, 22, 'https://images.unsplash.com/photo-1631679706909-1844bbd07221?w=500'],
        [$catIds['Maison & Décoration'], 'Plante Artificielle', 'Plante décorative réaliste sans entretien', 2500, 40, 'https://images.unsplash.com/photo-1463320726281-696a485928c7?w=500'],
        
        // Sports & Loisirs (10)
        [$catIds['Sports & Loisirs'], 'Tapis de Yoga Premium', 'Tapis antidérapant avec sac de transport', 4500, 35, 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=500'],
        [$catIds['Sports & Loisirs'], 'Haltères Réglables 20kg', 'Set d\'haltères ajustables pour musculation', 12500, 18, 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=500'],
        [$catIds['Sports & Loisirs'], 'Vélo d\'Appartement', 'Vélo stationnaire avec écran LCD', 45000, 10, 'https://images.unsplash.com/photo-1576678927484-cc907957088c?w=500'],
        [$catIds['Sports & Loisirs'], 'Ballon de Football', 'Ballon officiel taille 5', 3200, 50, 'https://images.unsplash.com/photo-1614632537423-1e6c2e7e0aac?w=500'],
        [$catIds['Sports & Loisirs'], 'Raquette de Tennis', 'Raquette professionnelle graphite', 15800, 15, 'https://images.unsplash.com/photo-1622163642998-1ea32b0bbc67?w=500'],
        [$catIds['Sports & Loisirs'], 'Sac de Sport', 'Sac de voyage multifonction imperméable', 5500, 28, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500'],
        [$catIds['Sports & Loisirs'], 'Gourde Isotherme 1L', 'Bouteille inox garde température 24h', 2800, 45, 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=500'],
        [$catIds['Sports & Loisirs'], 'Montre GPS Running', 'Montre sport avec cardio et GPS', 28000, 12, 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=500'],
        [$catIds['Sports & Loisirs'], 'Corde à Sauter Pro', 'Corde réglable avec compteur', 1800, 60, 'https://images.unsplash.com/photo-1598289431512-b97b0917affc?w=500'],
        [$catIds['Sports & Loisirs'], 'Tente Camping 4 Places', 'Tente familiale imperméable facile montage', 32000, 8, 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=500'],
        
        // Beauté & Santé (10)
        [$catIds['Beauté & Santé'], 'Sérum Vitamine C', 'Sérum anti-âge éclaircissant visage', 4500, 40, 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=500'],
        [$catIds['Beauté & Santé'], 'Crème Hydratante Bio', 'Crème visage naturelle tous types de peau', 3800, 45, 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=500'],
        [$catIds['Beauté & Santé'], 'Parfum Femme 100ml', 'Eau de parfum florale longue tenue', 12500, 25, 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=500'],
        [$catIds['Beauté & Santé'], 'Kit Maquillage Complet', 'Palette professionnelle 120 couleurs', 8500, 20, 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=500'],
        [$catIds['Beauté & Santé'], 'Brosse Nettoyante Visage', 'Brosse électrique silicone rechargeable', 6200, 30, 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=500'],
        [$catIds['Beauté & Santé'], 'Huile d\'Argan Pure', 'Huile 100% naturelle cheveux et peau', 2500, 50, 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=500'],
        [$catIds['Beauté & Santé'], 'Masque Cheveux Réparateur', 'Traitement intensif cheveux abîmés', 3200, 38, 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=500'],
        [$catIds['Beauté & Santé'], 'Vernis à Ongles Set', 'Collection de 12 vernis tendance', 4800, 35, 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=500'],
        [$catIds['Beauté & Santé'], 'Diffuseur Huiles Essentielles', 'Diffuseur aromathérapie avec LED', 5500, 28, 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=500'],
        [$catIds['Beauté & Santé'], 'Coffret Soin Homme', 'Kit complet rasage et soin visage', 7200, 22, 'https://images.unsplash.com/photo-1564182379166-8fcfdda80151?w=500']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO products (category_id, name, description, price, stock_quantity, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($products as $product) {
        $stmt->execute($product);
    }
    
    echo "✓ 50 produits ajoutés<br><br>";
    
    // Final count
    $cats = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    $prods = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    
    echo "<h3>✅ Base de données peuplée avec succès !</h3>";
    echo "📦 Catégories : $cats<br>";
    echo "🛍️ Produits : $prods<br><br>";
    echo "<a href='index.php'>Voir le site</a>";
    
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>

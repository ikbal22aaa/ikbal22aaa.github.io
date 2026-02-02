-- Database Export for ecommerce_db (HOSTING READY)
-- Generated on: 2026-01-29
-- This version includes CREATE TABLE statements and data

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    address TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `address`, `phone`, `created_at`) VALUES ('2', 'salaheddine', 'naimiikbal70@gmail.com', '$2y$10$CinSDqveIFdJJ1rwjkTilOFrnf2P/nrOdXqHdTT69CwVAuKZ2WnqS', 'user', 'AADL', '0657262213', '2025-12-21 16:22:13');
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `address`, `phone`, `created_at`) VALUES ('3', 'Admin', 'admin@shop.com', '$2y$10$ySMg5yq3JvEB0U558iZfNueCtHZ9TITi6AvR.XR63OCH1hd8njjui', 'admin', NULL, NULL, '2025-12-21 16:35:02');

-- 
-- Table structure for table `categories`
-- 

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255)
);

-- 
-- Dumping data for table `categories`
-- 

INSERT INTO `categories` (`id`, `name`, `description`, `image_url`) VALUES ('6', 'Électronique', 'Smartphones, ordinateurs, accessoires high-tech', 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=800');
INSERT INTO `categories` (`id`, `name`, `description`, `image_url`) VALUES ('7', 'Mode & Vêtements', 'Vêtements pour homme, femme et enfant', 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=800');
INSERT INTO `categories` (`id`, `name`, `description`, `image_url`) VALUES ('8', 'Maison & Décoration', 'Meubles, décoration et accessoires pour la maison', 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800');
INSERT INTO `categories` (`id`, `name`, `description`, `image_url`) VALUES ('9', 'Sports & Loisirs', 'Équipements sportifs et articles de loisirs', 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800');
INSERT INTO `categories` (`id`, `name`, `description`, `image_url`) VALUES ('10', 'Beauté & Santé', 'Produits de beauté, cosmétiques et bien-être', 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800');

-- 
-- Table structure for table `products`
-- 

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- 
-- Dumping data for table `products`
-- 

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('6', '6', 'iPhone 15 Pro', 'Smartphone Apple dernière génération avec puce A17', '180000.00', '11', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-1inch-naturaltitanium?wid=1280&hei=1280&fmt=jpeg&qlt=90&.v=1692845702275', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('7', '6', 'Samsung Galaxy S24', 'Flagship Samsung avec écran AMOLED 120Hz', '145000.00', '17', 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('8', '6', 'MacBook Air M3', 'Ordinateur portable ultra-léger et puissant', '220000.00', '7', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('9', '6', 'iPad Pro 12.9\"', 'Tablette professionnelle avec stylet Apple Pencil', '165000.00', '10', 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('10', '6', 'AirPods Pro 2', 'Écouteurs sans fil avec réduction de bruit', '35000.00', '24', 'https://images.unsplash.com/photo-1606841837239-c5a1a4a07af7?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('11', '6', 'Sony WH-1000XM5', 'Casque audio premium avec ANC', '48000.00', '15', 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('12', '6', 'Apple Watch Series 9', 'Montre connectée avec suivi santé avancé', '75000.00', '20', 'https://images.unsplash.com/photo-1434494878577-86c23bcb06b9?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('14', '6', 'PlayStation 5', 'Console de jeu nouvelle génération', '95000.00', '7', 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('15', '6', 'Logitech MX Master 3', 'Souris ergonomique sans fil', '15500.00', '30', 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('16', '7', 'Chemise Homme Blanche', 'Chemise en coton premium coupe slim', '4500.00', '40', 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('17', '7', 'Jean Slim Noir', 'Jean stretch confortable pour homme', '6800.00', '35', 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('18', '7', 'Robe d\'été Fleurie', 'Robe légère pour femme motif floral', '5200.00', '28', 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('19', '7', 'Veste en Cuir', 'Veste cuir véritable style biker', '18500.00', '12', 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('20', '7', 'Sneakers Nike Air Max', 'Chaussures de sport confortables', '12000.00', '22', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('21', '7', 'Sac à Main Cuir', 'Sac élégant en cuir pour femme', '9500.00', '18', 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('22', '7', 'Montre Classique', 'Montre analogique élégante', '8200.00', '25', 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('23', '7', 'Lunettes de Soleil', 'Lunettes UV protection style aviateur', '3500.00', '45', 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('24', '7', 'Écharpe en Laine', 'Écharpe douce et chaude pour hiver', '2800.00', '50', 'https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('26', '8', 'Canapé 3 Places Gris', 'Canapé confortable en tissu moderne', '65000.00', '7', 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('27', '8', 'Table Basse Bois', 'Table basse design en bois massif', '18500.00', '12', 'https://images.unsplash.com/photo-1532372320572-cda25653a26d?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('28', '8', 'Lampe LED Design', 'Lampe de salon moderne avec variateur', '7800.00', '25', 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('29', '8', 'Tapis Berbère 200x300', 'Tapis traditionnel fait main', '22000.00', '6', 'https://images.unsplash.com/photo-1600166898405-da9535204843?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('30', '8', 'Miroir Mural Rond', 'Miroir décoratif cadre doré', '5500.00', '20', 'https://images.unsplash.com/photo-1618220179428-22790b461013?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('31', '8', 'Coussin Décoratif Set', 'Lot de 4 coussins assortis', '4200.00', '30', 'https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('32', '8', 'Vase Céramique', 'Vase artisanal pour fleurs', '3800.00', '35', 'https://images.unsplash.com/photo-1578500494198-246f612d3b3d?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('33', '8', 'Horloge Murale', 'Horloge silencieuse design minimaliste', '4500.00', '28', 'https://images.unsplash.com/photo-1563861826100-9cb868fdbe1c?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('34', '8', 'Rideau Occultant', 'Paire de rideaux isolants thermiques', '6200.00', '22', 'https://images.unsplash.com/photo-1631679706909-1844bbd07221?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('35', '8', 'Plante Artificielle', 'Plante décorative réaliste sans entretien', '2500.00', '40', 'https://images.unsplash.com/photo-1463320726281-696a485928c7?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('36', '9', 'Tapis de Yoga Premium', 'Tapis antidérapant avec sac de transport', '4500.00', '35', 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('37', '9', 'Haltères Réglables 20kg', 'Set d\'haltères ajustables pour musculation', '12500.00', '18', 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('38', '9', 'Vélo d\'Appartement', 'Vélo stationnaire avec écran LCD', '45000.00', '10', 'https://images.unsplash.com/photo-1576678927484-cc907957088c?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('40', '9', 'Raquette de Tennis', 'Raquette professionnelle graphite', '15800.00', '14', 'https://images.unsplash.com/photo-1622163642998-1ea32b0bbc67?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('41', '9', 'Sac de Sport', 'Sac de voyage multifonction imperméable', '5500.00', '28', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('42', '9', 'Gourde Isotherme 1L', 'Bouteille inox garde température 24h', '2800.00', '44', 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('43', '9', 'Montre GPS Running', 'Montre sport avec cardio et GPS', '28000.00', '12', 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('44', '9', 'Corde à Sauter Pro', 'Corde réglable avec compteur', '1800.00', '60', 'https://images.unsplash.com/photo-1598289431512-b97b0917affc?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('45', '9', 'Tente Camping 4 Places', 'Tente familiale imperméable facile montage', '32000.00', '8', 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('46', '10', 'Sérum Vitamine C', 'Sérum anti-âge éclaircissant visage', '4500.00', '38', 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('47', '10', 'Crème Hydratante Bio', 'Crème visage naturelle tous types de peau', '3800.00', '45', 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('48', '10', 'Parfum Femme 100ml', 'Eau de parfum florale longue tenue', '12500.00', '25', 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('49', '10', 'Kit Maquillage Complet', 'Palette professionnelle 120 couleurs', '8500.00', '20', 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('50', '10', 'Brosse Nettoyante Visage', 'Brosse électrique silicone rechargeable', '6200.00', '30', 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('51', '10', 'Huile d\'Argan Pure', 'Huile 100% naturelle cheveux et peau', '2500.00', '50', 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('52', '10', 'Masque Cheveux Réparateur', 'Traitement intensif cheveux abîmés', '3200.00', '38', 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('53', '10', 'Vernis à Ongles Set', 'Collection de 12 vernis tendance', '4800.00', '35', 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('54', '10', 'Diffuseur Huiles Essentielles', 'Diffuseur aromathérapie avec LED', '5500.00', '28', 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=500', '2025-12-21 17:40:03');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`) VALUES ('55', '10', 'Coffret Soin Homme', 'Kit complet rasage et soin visage', '7200.00', '22', 'https://images.unsplash.com/photo-1564182379166-8fcfdda80151?w=500', '2025-12-21 17:40:03');

-- 
-- Table structure for table `orders`
-- 

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('en_attente', 'expediee', 'livree', 'annulee') DEFAULT 'en_attente',
    payment_method VARCHAR(50) DEFAULT 'cod',
    shipping_address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 
-- Dumping data for table `orders`
-- 

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `shipping_address`, `created_at`) VALUES ('2', '2', '278100.00', 'en_attente', 'cod', 'AADL', '2025-12-21 17:47:49');
INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `shipping_address`, `created_at`) VALUES ('3', '2', '145000.00', 'en_attente', 'cod', 'AADL', '2025-12-21 22:35:35');
INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `shipping_address`, `created_at`) VALUES ('4', '3', '180000.00', 'en_attente', 'cod', 'oran', '2025-12-21 22:43:20');
INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `shipping_address`, `created_at`) VALUES ('5', '2', '4500.00', 'en_attente', 'cod', 'AADL', '2025-12-21 22:46:12');
INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `shipping_address`, `created_at`) VALUES ('6', '2', '65000.00', 'en_attente', 'cod', 'AADL', '2025-12-22 11:00:44');

-- 
-- Table structure for table `order_items`
-- 

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- 
-- Dumping data for table `order_items`
-- 

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ('2', '2', '8', '1', '220000.00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ('3', '2', '10', '1', '35000.00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ('4', '2', '40', '1', '15800.00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ('5', '2', '42', '1', '2800.00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ('6', '2', '46', '1', '4500.00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ('7', '3', '7', '1', '145000.00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ('8', '4', '6', '1', '180000.00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ('9', '5', '46', '1', '4500.00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES ('10', '6', '26', '1', '65000.00');

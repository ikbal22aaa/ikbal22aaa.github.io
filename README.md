# 🛍️ E-Commerce Website - Boutique en Ligne

Site e-commerce complet développé en PHP avec MySQL, design moderne et interface en français.

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange)
![License](https://img.shields.io/badge/license-MIT-green)

---

## 📋 Table des Matières

- [Aperçu](#aperçu)
- [Fonctionnalités](#fonctionnalités)
- [Technologies Utilisées](#technologies-utilisées)
- [Installation Locale](#installation-locale)
- [Déploiement en Ligne](#déploiement-en-ligne)
- [Structure du Projet](#structure-du-projet)
- [Utilisation](#utilisation)
- [Captures d'Écran](#captures-décran)

---

## 🎯 Aperçu

Site e-commerce moderne permettant la vente en ligne de produits avec :
- Système de panier d'achat
- Gestion des commandes
- Panel d'administration
- Paiement à la livraison (COD)
- Prix en Dinar Algérien (DA)
- Interface entièrement en français

---

## ✨ Fonctionnalités

### Pour les Clients
- ✅ Navigation par catégories
- ✅ Recherche de produits
- ✅ Ajout au panier
- ✅ Gestion du panier (quantités, suppression)
- ✅ Processus de commande simplifié
- ✅ Affichage du stock disponible
- ✅ Système d'authentification (inscription/connexion)

### Pour les Administrateurs
- ✅ Dashboard d'administration
- ✅ Gestion des produits (CRUD complet)
- ✅ Gestion des catégories
- ✅ Gestion des commandes
- ✅ Suivi des statuts de commande

---

## 🛠️ Technologies Utilisées

### Frontend
- **HTML5** - Structure sémantique
- **CSS3** (Vanilla) - Design moderne avec variables CSS
- **JavaScript** - Interactions dynamiques
- **Google Fonts** - Typographie (Inter, Outfit)
- **Font Awesome** - Icônes

### Backend
- **PHP 7.4+** - Logique serveur
- **MySQL** - Base de données
- **PDO** - Connexion sécurisée à la base de données
- **Sessions PHP** - Gestion de l'authentification

### Serveur
- **Apache** - Serveur web
- **XAMPP** - Environnement de développement local

---

## 💻 Installation Locale

### Prérequis
- XAMPP (ou WAMP/MAMP)
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur

### Étapes d'installation

1. **Cloner ou télécharger le projet**
   ```bash
   # Placer les fichiers dans le dossier htdocs de XAMPP
   C:\xampp\htdocs\Ecommerce website\
   ```

2. **Démarrer les services**
   - Ouvrir XAMPP Control Panel
   - Démarrer Apache
   - Démarrer MySQL

3. **Créer la base de données**
   ```bash
   # Ouvrir phpMyAdmin : http://localhost/phpmyadmin
   # Exécuter le fichier setup.sql
   ```
   
   Ou via la ligne de commande :
   ```bash
   mysql -u root -e "source setup.sql"
   ```

4. **Peupler la base de données**
   ```bash
   php populate_database.php
   ```

5. **Accéder au site**
   ```
   http://localhost/Ecommerce website/index.php
   ```

### Compte Admin par défaut
```
Email: admin@shop.com
Mot de passe: admin123
```

---

## 🌐 Déploiement en Ligne

### Option 1 : InfinityFree (Gratuit)

Tous les fichiers nécessaires sont préparés :
- ✅ `database_export_2026-01-15_22-42-20.sql` - Export de la base de données
- ✅ `config_infinityfree.php` - Configuration pour l'hébergement
- ✅ `deployment_guide.md` - Guide complet de déploiement

**Suivez le guide détaillé** : [deployment_guide.md](deployment_guide.md)

### Option 2 : Hébergement Payant

Recommandations :
- **Hostinger** (~2-3€/mois) - Rapide et fiable
- **o2switch** (~5€/mois) - Tout illimité, support français

---

## 📁 Structure du Projet

```
Ecommerce website/
├── admin/                      # Panel d'administration
│   ├── categories.php         # Gestion des catégories
│   ├── dashboard.php          # Tableau de bord
│   ├── orders.php             # Gestion des commandes
│   ├── products.php           # Liste des produits
│   └── product_form.php       # Formulaire produit
├── assets/                     # Ressources statiques
│   ├── css/
│   │   └── style.css          # Styles principaux
│   └── images/                # Images du site
│       ├── products/          # Images des produits
│       ├── cat_*.jpg          # Images des catégories
│       └── hero_bg.jpg        # Image hero
├── includes/                   # Fichiers inclus
│   ├── header.php             # En-tête du site
│   └── footer.php             # Pied de page
├── auth.php                    # Vérification authentification
├── cart.php                    # Page panier
├── cart_actions.php           # Actions du panier
├── checkout.php               # Page de commande
├── config.php                 # Configuration BDD (local)
├── config_infinityfree.php    # Configuration BDD (hébergement)
├── index.php                  # Page d'accueil
├── login.php                  # Page de connexion
├── logout.php                 # Déconnexion
├── product.php                # Page détail produit
├── register.php               # Page d'inscription
├── shop.php                   # Page boutique
├── thank_you.php              # Page de confirmation
├── setup.sql                  # Structure de la BDD
├── populate_database.php      # Script de peuplement
└── database_export_*.sql      # Export de la BDD
```

---

## 🎮 Utilisation

### Navigation Client

1. **Page d'accueil** (`index.php`)
   - Affichage des catégories
   - Produits en vedette
   - Hero section

2. **Boutique** (`shop.php`)
   - Tous les produits
   - Filtrage par catégorie
   - Recherche de produits

3. **Détail Produit** (`product.php`)
   - Informations complètes
   - Stock disponible
   - Ajout au panier

4. **Panier** (`cart.php`)
   - Gestion des quantités
   - Calcul du total
   - Passage à la commande

5. **Commande** (`checkout.php`)
   - Formulaire de livraison
   - Confirmation de commande
   - Paiement à la livraison

### Panel Admin

1. **Dashboard** (`admin/dashboard.php`)
   - Statistiques générales
   - Aperçu des commandes

2. **Gestion Produits** (`admin/products.php`)
   - Liste des produits
   - Ajout/Modification/Suppression
   - Gestion du stock

3. **Gestion Catégories** (`admin/categories.php`)
   - CRUD complet des catégories

4. **Gestion Commandes** (`admin/orders.php`)
   - Liste des commandes
   - Changement de statut
   - Détails des commandes

---

## 📊 Base de Données

### Tables

1. **users** - Utilisateurs et administrateurs
2. **categories** - Catégories de produits
3. **products** - Produits du catalogue
4. **orders** - Commandes clients
5. **order_items** - Détails des commandes

### Données Initiales

- **5 catégories** : Électronique, Mode & Vêtements, Maison & Décoration, Sports & Loisirs, Beauté & Santé
- **47 produits** répartis dans les catégories
- **1 compte admin** : admin@shop.com / admin123

---

## 🎨 Design

### Palette de Couleurs
- **Primaire** : `#0f172a` (Bleu nuit profond)
- **Accent** : `#d4af37` (Or élégant)
- **Texte** : `#334155`
- **Background** : `#f8fafc`

### Typographie
- **Titres** : Outfit (Google Fonts)
- **Corps** : Inter (Google Fonts)

### Caractéristiques
- Design moderne et épuré
- Responsive (adapté mobile)
- Animations et transitions fluides
- Cards avec effets hover
- Formulaires stylisés

---

## 🔒 Sécurité

- ✅ Mots de passe hashés avec `password_hash()`
- ✅ Requêtes préparées PDO (protection SQL injection)
- ✅ Sessions PHP sécurisées
- ✅ Validation des données côté serveur
- ✅ Échappement HTML avec `htmlspecialchars()`

---

## 📝 Notes Importantes

### Limitations Actuelles
- Pas d'envoi d'emails (à configurer avec SMTP)
- Paiement uniquement à la livraison (COD)
- Images produits via URLs externes (Unsplash)

### Améliorations Futures
- [ ] Intégration paiement en ligne (Stripe, PayPal)
- [ ] Système d'envoi d'emails (confirmation commande)
- [ ] Upload d'images produits
- [ ] Système de reviews/avis
- [ ] Wishlist (liste de souhaits)
- [ ] Historique des commandes client
- [ ] Statistiques avancées admin

---

## 🤝 Contribution

Ce projet est un site e-commerce éducatif. N'hésitez pas à :
- Signaler des bugs
- Proposer des améliorations
- Ajouter des fonctionnalités

---

## 📄 License

Ce projet est sous licence MIT. Vous êtes libre de l'utiliser, le modifier et le distribuer.

---

## 👨‍💻 Auteur

Développé avec ❤️ pour l'apprentissage du développement web PHP/MySQL

---

## 📞 Support

Pour toute question ou problème :
1. Consultez le [Guide de Déploiement](deployment_guide.md)
2. Vérifiez la [Checklist de Déploiement](DEPLOYMENT_CHECKLIST.md)
3. Consultez les logs d'erreur PHP

---

**Bon développement ! 🚀**

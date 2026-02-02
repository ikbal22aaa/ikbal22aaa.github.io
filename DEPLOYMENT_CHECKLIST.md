# ✅ Checklist de Déploiement InfinityFree

## Avant de commencer

- [ ] Compte InfinityFree créé et activé
- [ ] FileZilla installé sur votre ordinateur
- [ ] Fichiers du site prêts dans `D:\xampp\htdocs\Ecommerce website`

---

## Fichiers Préparés ✅

- [x] **Base de données exportée** : `database_export_2026-01-15_22-42-20.sql` (19.10 KB)
- [x] **Configuration InfinityFree** : `config_infinityfree.php`
- [x] **Guide de déploiement** : Voir `deployment_guide.md`

---

## Étapes de Déploiement

### 1. Configuration InfinityFree
- [ ] Créer un nouveau site sur InfinityFree
- [ ] Noter les informations FTP et MySQL
- [ ] Copier les identifiants dans un endroit sûr

### 2. Upload FTP
- [ ] Se connecter à FileZilla avec les identifiants FTP
- [ ] Naviguer vers le dossier `htdocs` sur le serveur
- [ ] Uploader tous les fichiers PHP
- [ ] Uploader le dossier `assets` complet
- [ ] Uploader le dossier `includes`
- [ ] Uploader le dossier `admin`

### 3. Base de Données
- [ ] Accéder à phpMyAdmin depuis InfinityFree
- [ ] Importer le fichier `database_export_2026-01-15_22-42-20.sql`
- [ ] Vérifier que toutes les tables sont créées (5 tables)
- [ ] Vérifier que les données sont importées (47 produits, 5 catégories)

### 4. Configuration
- [ ] Éditer `config_infinityfree.php` avec les bonnes informations
- [ ] Sauvegarder et uploader le fichier modifié
- [ ] Renommer `config_infinityfree.php` en `config.php`

### 5. Tests
- [ ] Ouvrir la page d'accueil : `http://votre-site.infinityfreeapp.com`
- [ ] Tester la boutique : `/shop.php`
- [ ] Tester la connexion admin : `/login.php` (admin@shop.com / admin123)
- [ ] Tester le panier : Ajouter un produit au panier
- [ ] Vérifier que les images s'affichent

### 6. Sécurité
- [ ] Changer le mot de passe admin
- [ ] Supprimer les fichiers inutiles du serveur :
  - [ ] `export_database.php`
  - [ ] `remove_products.php`
  - [ ] `update_images.php`
  - [ ] Tous les fichiers `.sql` (après import)

---

## Informations Importantes

### Compte Admin par défaut
```
Email: admin@shop.com
Mot de passe: admin123
```
⚠️ **À CHANGER IMMÉDIATEMENT après le premier login !**

### Structure de la Base de Données
- **5 tables** : users, categories, products, orders, order_items
- **47 produits** répartis en 5 catégories
- **2 utilisateurs** : 1 admin + 1 utilisateur test

### Fichiers à ne PAS uploader
- ❌ `config.php` (local uniquement)
- ❌ `export_database.php`
- ❌ `remove_products.php`
- ❌ `update_images.php`
- ❌ `setup.sql`
- ❌ `populate_data.sql`

---

## En cas de problème

### Erreur de connexion à la base de données
1. Vérifier `config.php` sur le serveur
2. Vérifier que la base de données est bien importée
3. Vérifier les identifiants MySQL

### Page blanche
1. Activer l'affichage des erreurs PHP
2. Vérifier les logs dans le panneau InfinityFree
3. Vérifier que tous les fichiers sont uploadés

### Images manquantes
1. Vérifier que le dossier `assets/images` est uploadé
2. Les images Unsplash peuvent être bloquées (normal)
3. Uploader des images locales si nécessaire

---

## Ressources

- 📖 [Guide complet de déploiement](file:///C:/Users/naimi/.gemini/antigravity/brain/4c85927d-afd0-4e6b-8cab-bbd4d27cb4e8/deployment_guide.md)
- 🌐 [InfinityFree](https://infinityfree.net)
- 📁 [FileZilla](https://filezilla-project.org)
- 💬 [Forum InfinityFree](https://forum.infinityfree.net)

---

**Bonne chance ! 🚀**

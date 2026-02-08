# SAE3 - Plateforme d'Échange d'Objets

## 📋 Table des matières

- [Vue d'ensemble](#vue-densemble)
- [Architecture](#architecture)
- [Installation](#installation)
- [Configuration](#configuration)
- [Scripts utiles](#scripts-utiles)
- [Authentification](#authentification)
- [Endpoints principaux](#endpoints-principaux)
- [Rôles et permissions](#rôles-et-permissions)
- [Dépendances](#dépendances)
- [Auteurs](#Auteurs)

## 🎯 Vue d'ensemble

SAE3 est une plateforme web permettant aux étudiants, enseignants et chefs de département de gérer, proposer et échanger des objets au sein d'une université.

**Stack technique:**
- PHP 8+ (MVC custom)
- MySQL/MariaDB
- Apache 2 (avec mod_rewrite)
- Composer pour les dépendances

## 🏗️ Architecture

```
SAE3/
├── app/
│   ├── controllers/        # Logique métier (par rôle)
│   ├── models/             # Accès données (PDO)
│   ├── views/              # Templates HTML
│   ├── core/               # Classe de base (Controller, Model, View, Validator, ErrorHandler)
├── assets/                 # CSS, JS (organisés par rôle)
├── core/                   # Noyau du framework (alias)
├── scripts/                # Scripts CLI (migration, seed, audit)
├── logs/                   # Fichiers de logs (créés à l'exécution)
├── vendor/                 # Dépendances Composer
├── index.php               # Point d'entrée (routeur)
├── .env                    # Variables d'environnement (NON commité)
└── composer.json           # Gestion des dépendances
```

### Flux MVC

```
index.php (routeur)
  ↓
Controller (app/controllers/{Page}Controller.php)
  ↓ (appelle)
Model (app/models/{Entity}.php)
  ↓ (retourne)
View (app/views/{role}/{page}.php) + rendu
```

## 🚀 Installation

### Localement (Windows + XAMPP)

1. **Cloner le repo:**
   ```bash
   git clone https://github.com/XwerieS/SAE3.git c:\xampp\htdocs\SAE3
   cd c:\xampp\htdocs\SAE3
   ```

2. **Installer les dépendances:**
   ```bash
   composer install
   ```

3. **Créer et configurer `.env`:**
   ```bash
   cp .env.example .env
   # Éditer .env avec tes paramètres de base de données
   ```

4. **Importer la base de données:**
   ```bash
   # Via phpMyAdmin ou :
   mysql -u root -p SAE3 < database.sql
   ```

5. **Démarrer Apache et MySQL (XAMPP Control Panel)**

6. **Accéder:** `http://localhost/SAE3`

### Sur VM Linux (Debian/Ubuntu)

1. **SSH sur la VM:**
   ```bash
   ssh user@vm-ip
   cd /var/www/html
   ```

2. **Cloner avec Git:**
   ```bash
   git clone https://github.com/XwerieS/SAE3.git
   cd SAE3
   ```

3. **Installer les dépendances:**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

4. **Configurer `.env`:**
   ```bash
   nano .env
   # DB_HOST=localhost
   # DB_NAME=SAE3
   # DB_USER=etu
   # DB_PASS=password
   ```

5. **Permissions:**
   ```bash
   sudo chown -R www-data:www-data /var/www/html/SAE3
   sudo chmod 755 /var/www/html/SAE3
   ```

6. **Apache config:**
   ```bash
   sudo nano /etc/apache2/sites-available/sae3.conf
   ```
   ```apache
   <VirtualHost *:80>
       ServerName sae3.local
       DocumentRoot /var/www/html/SAE3
       <Directory /var/www/html/SAE3>
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

   ```bash
   sudo a2enmod rewrite
   sudo a2ensite sae3.conf
   sudo systemctl restart apache2
   ```

7. **Importer la base:**
   ```bash
   mysql -u etu -p SAE3 < database.sql
   ```

## ⚙️ Configuration

### Fichier `.env`

```env
# Base de données
DB_HOST=localhost
DB_PORT=3306
DB_NAME=SAE3
DB_USER=etu
DB_PASS=your_password
```

### Variables de session

Stockées dans `$_SESSION`:
- `id_user` — ID de l'utilisateur connecté
- `nom_user`, `prenom_user`, `mail_user` — Infos utilisateur
- `id_role` — Rôle (1=Chef Dept, 2=Étudiant, 3=Enseignant)
- `id_dep` — ID du département

## 🔧 Scripts utiles

Tous les scripts se trouvent dans `scripts/` et se lancent via CLI PHP.

### Migration des mots de passe

**Hash all plaintext passwords:**
```bash
php scripts/hash_passwords.php
```

**Options:**
- `--dry-run` : Affiche ce qui serait modifié, sans écrire.
- `--alter` : Agrandit la colonne `mdp_user` si nécessaire (VARCHAR(255)).
- `--force` : Force le hachage même si déjà hashé (dangereux, utiliser seulement si certain).

### Seed d'utilisateurs de test

```bash
php scripts/seed_test_users.php
```

Insère 10 utilisateurs de test avec mots de passe hachés. Les identifiants sont dans le tableau du script.

### Audit des utilisateurs

```bash
php scripts/export_users_audit.php
```

Exporte un CSV listant tous les utilisateurs avec ID, email, statut du mot de passe (plaintext/hashed) et rôle.

## 🔐 Authentification

### Flux de connexion

1. Utilisateur soumet `id_user` + mot de passe.
2. `LoginController` appelle `UserModel::checkCredentials()`.
3. Le modèle récupère le hash stocké et utilise `password_verify()`.
4. Si plaintext en clair détecté → rehach automatique et mise à jour DB.
5. Session créée si succès.

### Vérification dans les contrôleurs

```php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: /index.php?page=login');
    exit;
}
```

### Changer un mot de passe

```php
use App\Models\UserModel;

$user = new UserModel();
$user->updatePassword($id_user, $new_plaintext_password);
```

## 📡 Endpoints principaux

| Page | URL | Rôle(s) | Description |
|------|-----|---------|-------------|
| Tableau de bord | `?page=tableaudebord` | Tous | Accueil personnalisé |
| Login | `?page=login` | Visiteur | Connexion |
| Échange | `?page=etuEchange` | Étudiant | Proposer/réserver des objets |
| Recherche | `?page=etuRechEtRes` | Étudiant | Chercher et réserver |
| Chef Dept | `?page=chefDepTabDeBord` | Chef Dept | Tableau de bord spécifique |
| Gestion objets | `?page=chefDepInv` | Chef Dept | Gérer l'inventaire |
| Enseignant | `?page=enseignantBesoins` | Enseignant | Signaler des besoins |

## 👥 Rôles et permissions

| Rôle | ID | Permissions |
|------|----|----|
| Chef Département | 1 | Gérer inventaire, valider propositions, créer campanges |
| Étudiant | 2 | Proposer objets, réserver, participer à des échanges |
| Enseignant | 3 | Consulter ressources, signaler besoins |

## 📦 Dépendances

Les dépendances sont gérées via `composer.json`:

```bash
# Installer tout
composer install

# Installer en production (sans dev)
composer install --no-dev --optimize-autoloader

# Mettre à jour
composer update
```

**Dépendances principales:**
- `vlucas/phpdotenv` — Gestion des variables d'environnement

## 🛠️ Validation serveur

La classe `App\Core\Validator` est disponible pour valider les données côté serveur:

```php
use App\Core\Validator;

$v = new Validator();
$v->required($_POST['email'], 'Email')
  ->email($_POST['email'])
  ->required($_POST['password'], 'Password')
  ->password($_POST['password']);

if (!$v->isValid()) {
    $errors = $v->getErrors();
    // Afficher les erreurs à l'utilisateur
}
```

**Méthodes disponibles:**
- `required($value, $fieldName)` — Champ obligatoire
- `email($value, $fieldName)` — Format email valide
- `password($value, $fieldName)` — Min 8 chars, 1 chiffre, 1 lettre
- `minLength($value, $min, $fieldName)` — Longueur minimale
- `maxLength($value, $max, $fieldName)` — Longueur maximale
- `numeric($value, $fieldName)` — Valeur numérique
- `integer($value, $fieldName)` — Entier
- `url($value, $fieldName)` — URL valide
- `in($value, $allowed, $fieldName)` — Valeur dans liste

## 📜 Gestion des erreurs

Les erreurs PHP et exceptions sont affichées:
- **404** — Page/ressource non trouvée (vérifier contrôleur et action)

## 🐛 Troubleshooting

### "Page non trouvée" (404)

1. Vérifier que le contrôleur existe: `app/controllers/{Page}Controller.php`
2. Vérifier que la classe est nommée correctement
3. Vérifier les logs: consulter les fichiers dans le répertoire `logs/` ou Apache
4. Sur Linux, vérifier la casing des fichiers (sensible à la casse)

### "Erreur de connexion à la base" (500)

1. Vérifier que le `.env` existe et est lisible
2. Tester la connexion MySQL:
   ```bash
   mysql -h localhost -u etu -p SAE3 -e "SELECT 1"
   ```
3. Vérifier les logs Apache: `/var/log/apache2/error.log`

### Mots de passe ne se synchronisent pas

1. Lancer la migration:
   ```bash
   php scripts/hash_passwords.php --dry-run
   ```
2. Si tout est déjà hashé mais connexion échoue → vérifier le plaintext de test
3. Forcer la rehachure (dernier recours):
   ```bash
   php scripts/hash_passwords.php --force
   ```

### Permissions fichiers (Linux)

```bash
sudo chown -R www-data:www-data /var/www/html/SAE3
chmod 755 /var/www/html/SAE3
chmod 644 /var/www/html/SAE3/.env
```

## 📝 Notes de développement

- Toujours valider côté serveur, jamais faire confiance au client
- Hacher les mots de passe avec `password_hash(plain, PASSWORD_DEFAULT)`
- Vérifier avec `password_verify(plain, hash)`
- Utiliser prepared statements (PDO) pour éviter les injections SQL

## Auteurs 

- [@XwerieS](https://github.com/XwerieS)
- [@AlixCORBIN](https://github.com/AlixCORBIN)
- [@NoanHeinry](https://github.com/NoanHeinry)
- [@TiboTsr](https://github.com/TiboTsr)

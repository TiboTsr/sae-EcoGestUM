<?php
// CLI script to migrate plaintext passwords to password_hash
// Usage:
//   php scripts/hash_passwords.php            # exécute la migration
//   php scripts/hash_passwords.php --dry-run  # n'écrit rien, affiche ce qui serait modifié
//   php scripts/hash_passwords.php --alter    # auto-augmente la taille de la colonne si nécessaire

error_reporting(E_ALL);
ini_set('display_errors', 1);

$args = $argv ?? [];
$dryRun = in_array('--dry-run', $args, true);
$autoAlter = in_array('--alter', $args, true);
$force = in_array('--force', $args, true);

$root = dirname(__DIR__);
require_once $root . '/vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable($root);
$dotenv->load();

try {
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8',
        $_ENV['DB_HOST'], $_ENV['DB_PORT'], $_ENV['DB_NAME']
    );
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (Throwable $e) {
    fwrite(STDERR, "DB connection failed: " . $e->getMessage() . PHP_EOL);
    exit(1);
}

// Affiche la base sélectionnée et l'hôte pour éviter les confusions d'environnement
$dbName = $_ENV['DB_NAME'] ?? '(inconnu)';
$dbHost = $_ENV['DB_HOST'] ?? '(inconnu)';
echo "Connexion OK sur {$dbHost}/{$dbName}" . PHP_EOL;

// Vérifier la taille de la colonne mdp_user
$lenStmt = $pdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH AS max_len
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'UTILISATEUR' AND COLUMN_NAME = 'mdp_user'");
$lenStmt->execute();
$lenRow = $lenStmt->fetch(PDO::FETCH_ASSOC);
if ($lenRow && isset($lenRow['max_len'])) {
    $maxLen = (int)$lenRow['max_len'];
    echo "Taille actuelle de UTILISATEUR.mdp_user: {$maxLen}" . PHP_EOL;
    if ($maxLen < 60) {
        $msg = "ATTENTION: la colonne mdp_user ({$maxLen}) est trop courte pour stocker un hash (~60).";
        if ($autoAlter) {
            echo $msg . " Tentative d'ALTER en VARCHAR(255)..." . PHP_EOL;
            $pdo->exec("ALTER TABLE UTILISATEUR MODIFY mdp_user VARCHAR(255) NOT NULL");
            echo "ALTER effectué." . PHP_EOL;
        } else {
            fwrite(STDERR, $msg . PHP_EOL);
            fwrite(STDERR, "Relancez avec --alter ou exécutez: ALTER TABLE UTILISATEUR MODIFY mdp_user VARCHAR(255) NOT NULL;" . PHP_EOL);
            exit(2);
        }
    }
}

$select = $pdo->query("SELECT id_user, mdp_user FROM UTILISATEUR");
$users = $select->fetchAll(PDO::FETCH_ASSOC);

// Détection robuste d'un hash connu (bcrypt/argon2)
$isLikelyHash = function(string $val): bool {
    $val = trim($val);
    if ($val === '') return false;
    if (preg_match('/^\$2[aby]\$\d{2}\$[A-Za-z0-9\.\/]{53}$/', $val)) return true; // bcrypt
    if (preg_match('/^\$argon2(id|i)\$/', $val)) return true; // argon2id/argon2i
    return false;
};

$updated = 0; $skipped = 0; $already = 0; $preview = 0;

foreach ($users as $u) {
    $id = $u['id_user'];
    $stored = trim((string)($u['mdp_user'] ?? ''));

    // Déjà hashé ? (détection stricte via regex), sauf si --force
    $pwInfo = password_get_info($stored);
    $detectedByRegex = $isLikelyHash($stored);
    $detectedByInfo = ($pwInfo['algo'] ?? 0) !== 0;
    $isHashed = $detectedByRegex || $detectedByInfo;
    if ($dryRun && $preview < 10) {
        echo "[CHECK] id_user={$id} len=" . strlen($stored) . " regex=" . ($detectedByRegex?'yes':'no') . " infoAlgo=" . ($detectedByInfo?($pwInfo['algoName']??'nonzero'):'0') . PHP_EOL;
        $preview++;
    }
    if ($isHashed && !$force) {
        $already++;
        continue;
    }

    // Vide => impossible de déduire le mot de passe d'origine
    if ($stored === '') {
        $skipped++;
        continue;
    }

    if ($dryRun && $preview < 10) {
        echo "[DRY-RUN] id_user={$id} sera hashé (valeur actuelle: '{$stored}')" . PHP_EOL;
        $preview++;
    }

    if (!$dryRun) {
        $hash = password_hash($stored, PASSWORD_DEFAULT);
        $upd = $pdo->prepare('UPDATE UTILISATEUR SET mdp_user = :hash WHERE id_user = :id');
        $upd->execute([':hash' => $hash, ':id' => $id]);
    }
    $updated++;
}

echo ($dryRun ? "Simulation terminée." : "Migration terminée.") . PHP_EOL;
echo "Déjà hashés: {$already}" . PHP_EOL;
echo ($dryRun ? "Seront mis à jour: {$updated}" : "Mises à jour: {$updated}") . PHP_EOL;
echo "Ignorés (vides): {$skipped}" . PHP_EOL;

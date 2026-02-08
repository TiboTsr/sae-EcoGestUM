<?php
class UserModel {
    private $pdo;

    public function __construct() {
        // On charge les variables d'environnement si elles ne le sont pas déjà
        if (!isset($_ENV['DB_HOST']) && file_exists(__DIR__ . '/../../.env')) {
            $env = parse_ini_file(__DIR__ . '/../../.env');
            foreach ($env as $key => $value) $_ENV[$key] = $value;
        }

        $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']};charset=utf8";
        $this->pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function checkCredentials($id, $mdp) {
        // Désormais: on récupère l'utilisateur par id_user uniquement et on vérifie via password_verify
        $sql = "SELECT U.*, R.nom_role 
                FROM UTILISATEUR U
                JOIN ROLE R ON U.id_role = R.id_role
                WHERE U.id_user = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) return false;

        $stored = $user['mdp_user'] ?? '';

        // Cas 1: mdp déjà hashé
        if (password_get_info($stored)['algo'] !== 0) {
            if (password_verify($mdp, $stored)) {
                return $user;
            }
            return false;
        }

        // Cas 2: ancien mot de passe en clair (migration progressive)
        if (hash_equals($stored, $mdp)) {
            // On rehash et on met à jour pour sécuriser définitivement
            $newHash = password_hash($mdp, PASSWORD_DEFAULT);
            try {
                $upd = $this->pdo->prepare("UPDATE UTILISATEUR SET mdp_user = :hash WHERE id_user = :id");
                $upd->execute([':hash' => $newHash, ':id' => $user['id_user']]);
            } catch (Exception $e) {
                // en cas d'erreur d'update, on n'empêche pas la connexion si le mdp est correct
            }
            return $user;
        }

        return false;
    }

    public function updatePassword($id_user, $plainPassword): bool {
        $hash = password_hash($plainPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE UTILISATEUR SET mdp_user = :hash WHERE id_user = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':hash' => $hash, ':id' => $id_user]);
    }
}
?>
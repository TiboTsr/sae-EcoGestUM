<?php
class View {
    /**
     * Résout un chemin case-insensitively en cherchant dans le filesystem
     * Utile pour Linux qui est sensible à la casse
     */
    private static function resolvePath($basePath, $relativePath) {
        // Nettoyer le chemin
        $relativePath = trim(str_replace('\\', '/', $relativePath), '/');
        if ($relativePath === '') {
            return $basePath;
        }

        $segments = explode('/', $relativePath);
        $current = rtrim($basePath, DIRECTORY_SEPARATOR . '/');

        foreach ($segments as $segment) {
            if (trim($segment) === '') {
                continue;
            }

            // Lire le répertoire courant
            $entries = @scandir($current);
            if ($entries === false) {
                return null; // Impossible de lire le dossier
            }

            // Chercher une correspondance insensible à la casse
            $found = null;
            foreach ($entries as $entry) {
                if (strcasecmp($entry, $segment) === 0) {
                    $found = $entry;
                    break;
                }
            }

            // Ajouter le segment trouvé ou le segment original
            $current .= DIRECTORY_SEPARATOR . ($found !== null ? $found : $segment);
        }

        return $current;
    }

    public static function render($viewName, $data = []) {
        extract($data);

        $basePath = realpath(__DIR__ . '/../app/views');
        if ($basePath === false) {
            $basePath = __DIR__ . '/../app/views';
        }

        // Essayer d'abord le chemin exact tel que fourni
        $filePath = $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $viewName) . '.php';

        if (!file_exists($filePath)) {
            // Sinon, résoudre case-insensitively
            $resolved = self::resolvePath($basePath, $viewName . '.php');
            if ($resolved !== null && file_exists($resolved)) {
                $filePath = $resolved;
            }
        }

        if (!file_exists($filePath)) {
            die("Vue non trouvée: " . htmlspecialchars($viewName) . " (chemin: " . htmlspecialchars($filePath) . ")");
        }

        require_once $filePath;
    }
}
?>
<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Debug helper: add ?debug=1 to show PHP errors temporarily
if (isset($_GET['debug'])) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

spl_autoload_register(function ($class) {
    // Chemins de recherche des contrôleurs (par rôle)
    $dirs = [
        __DIR__ . "/app/controllers/",                 // Généraux
        __DIR__ . "/app/controllers/chefDep/",         // Chef Dept
        __DIR__ . "/app/controllers/enseignant/",      // Enseignant
        __DIR__ . "/app/controllers/etudiant/",        // Étudiant
    ];

    // Essayer différentes variantes de casse pour compat Linux/Windows
    $candidates = [
        $class . '.php',                  // EtuPropController.php
        lcfirst($class) . '.php',         // etuPropController.php
        strtolower($class) . '.php',      // etupropcontroller.php
    ];

    foreach ($dirs as $dir) {
        foreach ($candidates as $fileName) {
            $file = $dir . $fileName;
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
});

$page = $_GET['page'] ?? 'tableaudebord';
$action = $_GET['action'] ?? 'index';

// Mapping des noms de page vers les noms de contrôleurs
$pageMap = [
    'tableaudebord' => 'TableaudebordController',
    'login' => 'LoginController',
    'loginLMU' => 'LoginLMUController',
    'nosvaleurs' => 'NosvaleursController',
    'sidebar' => 'SideBarController',
    // Chef de département
    'chefDepAddObj' => 'ChefDepAddObjController',
    'chefDepCollab' => 'ChefDepCollabController',
    'chefDepHisto' => 'ChefDepHistoController',
    'chefDepInv' => 'ChefDepInvController',
    'chefDepNotif' => 'ChefDepNotifController',
    'chefDepTabDeBord' => 'ChefDepTabDeBordController',
    // Enseignant
    'enseignantBesoins' => 'EnseignantBesoinsController',
    'enseignantCollab' => 'EnseignantCollabController',
    'enseignantGuide' => 'EnseignantGuideController',
    'enseignantNotif' => 'EnseignantNotifController',
    'enseignantProposer' => 'EnseignantProposerController',
    'enseignantRecherche' => 'EnseignantRechercheController',
    // Étudiant
    'etuCampagne' => 'EtuCampagneController',
    'etuCarte' => 'EtuCarteController',
    'etuEchange' => 'EtuEchangeController',
    'etuNotif' => 'EtuNotifController',
    'etuProp' => 'EtuPropController',
    'etuRechEtRes' => 'EtuRechEtResController',
    'etuSignaler' => 'EtuSignalerController',
];

$controllerName = $pageMap[$page] ?? ucfirst($page) . 'Controller';

if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        include __DIR__ . '/app/views/errors/404.php';
    }
} else {
    http_response_code(404);
    include __DIR__ . '/app/views/errors/404.php';
}


?>

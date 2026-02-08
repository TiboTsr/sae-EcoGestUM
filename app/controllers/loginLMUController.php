<?php

require_once __DIR__ . '/../models/userModel.php';
require_once __DIR__ . '/../../core/Controller.php';
require_once 'core/View.php';

class LoginLMUController extends Controller {

    public function index() {
        $data = [
            'title' => 'Login LMU',
        ];
        $this->loadView('loginLMU', $data);
    }

    public function authenticate() {
        // Récupération des données du formulaire
        $id = $_POST['id_user'] ?? '';
        $mdp = $_POST['mdp_user'] ?? '';

        $model = new UserModel();
        
        // 1. On récupère les infos complètes depuis la BDD
        // (Assurez-vous que checkCredentials fait bien la jointure, voir ci-dessous)
        $user = $model->checkCredentials($id, $mdp);

        if ($user) {
            // 2. Démarrage sécurisé de la session
            if (session_status() === PHP_SESSION_NONE) session_start();

            // 3. On stocke TOUTES les infos de l'utilisateur dans la session
            // Cela inclura : id_user, nom_user, id_role, nom_role, etc.
            $_SESSION['user'] = $user;
            
            // 4. Redirection selon l'ID du rôle
            switch ($user['id_role']) {
                case 1:
                    header("Location: index.php?page=chefDepInv"); exit();
                case 2:
                    header("Location: index.php?page=etuRechEtRes"); exit();
                case 3:
                    header("Location: index.php?page=enseignantRecherche"); exit();
                default:
                    header("Location: index.php?page=home"); exit();
            }
        } else {
            $this->loadView('loginLMU', ['error' => 'Identifiants incorrects']);
        }
    }
}
?>
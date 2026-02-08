<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php'; // Important pour éviter l'erreur "Class View not found"
require_once __DIR__ . '/../../models/Recyclage.php'; // On inclut le nouveau modèle

class ChefDepHistoController extends Controller {
    public function index() {

        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']['id_dep'])) {
            header('Location: index.php?page=loginLMU');
            exit();
        }

        $id_dep = $_SESSION['user']['id_dep'];

        $recyclageModel = new Recyclage();
        $historique = $recyclageModel->getHistoriqueByDepartement($id_dep);

        $data = [
            'title' => 'Historique',
            'historique' => $historique 
        ];

        $this->loadView('chefDep/chefDepHisto', $data);
    }
}

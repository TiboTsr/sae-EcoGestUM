<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Objet.php'; 


class ChefDepInvController extends Controller {
    public function index() {
        
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']['id_dep'])) {
            header('Location: index.php?page=login');
            exit();
        }

        $id_dep = $_SESSION['user']['id_dep'];

        $objetModel = new Objet();
        $objets = $objetModel->getObjetsByDepartement($id_dep);

        $data = [
            'title' => 'Inventaire des ressources recyclables',
            'objets' => $objets 
        ];

        $this->loadView('/chefDep/chefDepInv', $data);
    }
}

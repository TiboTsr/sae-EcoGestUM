<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Statistique.php';

class ChefDepTabDeBordController extends Controller {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']['id_dep'])) {
            header('Location: index.php?page=loginLMU');
            exit();
        }

        $id_dep = $_SESSION['user']['id_dep'];
        $statModel = new Statistique();

        $economie = $statModel->getEconomieRealisee($id_dep);
        $poidsRecycle = $statModel->getPoidsRecycle($id_dep);
        $tauxReutilisation = $statModel->getTauxReutilisation($id_dep);
        $evolutionData = $statModel->getEvolutionCarbone($id_dep);
        $meilleurRecycleur = $statModel->getMeilleurRecycleur($id_dep);
        $repartitionData = $statModel->getRepartitionMateriaux($id_dep);

        $data = [
            'title' => 'Tableau de bord',
            'economie' => $economie,
            'poids' => $poidsRecycle,
            'taux' => $tauxReutilisation,
            'topRecycleur' => $meilleurRecycleur,
            'repartitionData' => $repartitionData,
            'jsonLabelsLine' => json_encode(array_column($evolutionData, 'annee')),
            'jsonDataLine' => json_encode(array_column($evolutionData, 'total')),
            'jsonLabelsDonut' => json_encode(array_column($repartitionData, 'nom_cat')),
            'jsonDataDonut' => json_encode(array_column($repartitionData, 'total'))
        ];

        $this->loadView('/chefDep/chefDepTabDeBord', $data);
    }
}

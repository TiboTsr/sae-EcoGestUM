<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Objet.php';

class EtuRechEtResController extends Controller
{

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id_user = $_SESSION['user']['id_user'];
        $objetModel = new Objet();

        $categories = $_GET['cat'] ?? [];
        $etats = $_GET['etat'] ?? [];
        $search = $_GET['search'] ?? '';

        $resultats = $objetModel->rechercherAvecFiltres($categories, $etats, $search);

        $mesReservations = $objetModel->getMesReservations($id_user);

        $data = [
            'title'        => 'Recherche et réservation',
            'objets'       => $resultats,
            'reservations' => $mesReservations,
            'filtres_cat'  => $categories,
            'filtres_etat' => $etats,
            'search_term'  => $search
        ];

        $this->loadView('/etudiant/etuRechEtRes', $data);
    }

    public function reserver()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id_obj = $_POST['id_obj'] ?? null;
            $usage = $_POST['usage'] ?? 'Aucun motif';
            $quantite = intval($_POST['quantite'] ?? 1);

            $id_user = $_SESSION['user']['id_user'];

            if ($id_obj && $quantite > 0) {
                $objetModel = new Objet();

                $success = $objetModel->reserverObjet($id_obj, $id_user, $usage, $quantite);

                if ($success) {
                    header('Location: index.php?page=EtuRechEtRes&action=index&success=1');
                    exit;
                } else {
                    echo "Erreur : Stock insuffisant ou problème lors de la réservation.";
                }
            } else {
                echo "Erreur : Données invalides.";
            }
        }
    }

    public function annuler()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_res = $_POST['id_res'] ?? null;

            if ($id_res) {
                $objetModel = new Objet();
                $objetModel->annulerReservation($id_res);

                header('Location: index.php?page=EtuRechEtRes&action=index&msg=canceled');
                exit;
            }
        }
    }
}

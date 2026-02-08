<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Objet.php';

class EnseignantRechercheController extends Controller {
    public function index() {

        $objetModel = new Objet();

        $categories = $_GET['cat'] ?? [];
        $etats = $_GET['etat'] ?? [];
        $search = $_GET['search'] ?? '';

        $resultats = $objetModel->rechercherAvecFiltres($categories, $etats, $search);

        // Récupérer les réservations de l'utilisateur connecté (si session active)
        if (session_status() === PHP_SESSION_NONE) session_start();
        $id_user = $_SESSION['user']['id_user'] ?? null;
        $mesReservations = [];
        if ($id_user) {
            $mesReservations = $objetModel->getMesReservations($id_user);
        }

        $data = [
            'title'        => 'Recherche et réservation',
            'objets'       => $resultats,
            'reservations' => $mesReservations,
            'filtres_cat'  => $categories,
            'filtres_etat' => $etats,
            'search_term'  => $search
        ];

        $this->loadView('/enseignant/enseignantRecherche', $data);
    }

    public function reserver() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_obj = $_POST['id_obj'] ?? null;
            $usage = $_POST['usage'] ?? 'Aucun motif';
            $quantite = intval($_POST['quantite'] ?? 1);

            // Récupérer l'ID utilisateur depuis la session si présent
            if (session_status() === PHP_SESSION_NONE) session_start();
            $id_user = $_SESSION['user']['id_user'] ?? 1; // fallback

            if ($id_obj && $quantite > 0) {
                $objetModel = new Objet();
                $success = $objetModel->reserverObjet($id_obj, $id_user, $usage, $quantite);

                if ($success) {
                    header('Location: index.php?page=enseignantRecherche&action=index&success=1');
                    exit;
                } else {
                    header('Location: index.php?page=enseignantRecherche&action=index&success=0&error=stock');
                    exit;
                }
            } else {
                header('Location: index.php?page=enseignantRecherche&action=index&success=0&error=invalid');
                exit;
            }
        }
    }

    public function annuler() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_res = $_POST['id_res'] ?? null;

            if ($id_res) {
                $objetModel = new Objet();
                $objetModel->annulerReservation($id_res);
                header('Location: index.php?page=enseignantRecherche&action=index&msg=canceled');
                exit;
            }
        }
    }
}
    

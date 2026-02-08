<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Collab.php';

class ChefDepCollabController extends Controller {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']['id_dep'])) {
            header('Location: index.php?page=loginLMU');
            exit();
        }

        $id_dep = $_SESSION['user']['id_dep'];
        $collabModel = new Collab();
        $message = null;
        $message_type = null;

        // Traitement du formulaire d'ajout (si soumis)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars($_POST['nom'] ?? '');
            $catNom = $_POST['categorie'] ?? '';
            $etat = $_POST['etat'] ?? '';
            $quantite = intval($_POST['quantite'] ?? 0);
            $description = htmlspecialchars($_POST['description'] ?? '');

            if (!empty($nom) && !empty($catNom) && !empty($etat) && $quantite > 0) {
                $id_invent = $collabModel->getIdInventaireByDep($id_dep);
                $id_cat = $collabModel->getIdCategorieByNom($catNom);

                if ($id_invent && $id_cat) {
                    if ($collabModel->ajouterObjet($nom, $description, $etat, $quantite, $id_cat, $id_invent)) {
                        $message = "Objet ajouté et partagé avec succès !";
                        $message_type = "success";
                    } else {
                        $message = "Erreur lors de l'ajout.";
                        $message_type = "error";
                    }
                }
            } else {
                $message = "Veuillez remplir tous les champs.";
                $message_type = "error";
            }
        }

        // Récupérer les ressources des autres départements
        $ressources = $collabModel->getObjetsAutresDepartements($id_dep);

        $data = [
            'title' => 'Collaboration entre départements',
            'ressources' => $ressources,
            'message' => $message,
            'message_type' => $message_type
        ];

        $this->loadView('chefDep/chefDepCollab', $data);
    }
}

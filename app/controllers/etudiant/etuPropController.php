<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Objet.php';

class EtuPropController extends Controller
{

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $data = [
            'title' => 'Ajouter un objet',
            'message' => null,
            'message_type' => null
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nom = htmlspecialchars($_POST['nom'] ?? '');
            $categorieNom = $_POST['categorie'] ?? '';
            $etat = $_POST['etat'] ?? '';
            $quantite = intval($_POST['quantite'] ?? 0);
            $description = htmlspecialchars($_POST['description'] ?? '');

            if (!empty($nom) && !empty($categorieNom) && !empty($etat) && $quantite > 0) {

                $objetModel = new Objet();

                $id_dep = $_SESSION['user']['id_dep'] ?? null;

                if ($id_dep) {
                    $id_invent = $objetModel->getIdInventaireByDep($id_dep);


                    $id_cat = $objetModel->getIdCategorieByNom($categorieNom);


                    if ($id_invent && $id_cat) {
                        $succes = $objetModel->ajouterObjet($nom, $description, $etat, $quantite, $id_cat, $id_invent);

                        if ($succes) {
                            $data['message'] = "Objet ajouté avec succès !";
                            $data['message_type'] = "success";
                        } else {
                            $data['message'] = "Erreur lors de l'insertion en base de données.";
                            $data['message_type'] = "error";
                        }
                    } else {
                        $data['message'] = "Erreur : Catégorie ou Inventaire introuvable.";
                        $data['message_type'] = "error";
                    }
                } else {
                    $data['message'] = "Erreur : Vous n'êtes pas lié à un département.";
                    $data['message_type'] = "error";
                }
            } else {
                $data['message'] = "Veuillez remplir tous les champs obligatoires.";
                $data['message_type'] = "error";
            }
        }

        // Respecter la casse du fichier de vue (Linux case-sensitive)
        $this->loadView('etudiant/etuProp', $data);
    }
}

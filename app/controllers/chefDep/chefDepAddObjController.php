<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Objet.php';

class ChefDepAddObjController extends Controller {
    
    public function index() {
        // Démarrer la session si besoin pour récupérer l'utilisateur
        if (session_status() === PHP_SESSION_NONE) session_start();

        $data = [
            'title' => 'Ajouter un objet',
            'message' => null,
            'message_type' => null // 'success' ou 'error'
        ];

        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Récupération et nettoyage des champs
            $nom = htmlspecialchars($_POST['nom'] ?? '');
            $categorieNom = $_POST['categorie'] ?? '';
            $etat = $_POST['etat'] ?? '';
            $quantite = intval($_POST['quantite'] ?? 0);
            $description = htmlspecialchars($_POST['description'] ?? '');

            // 2. Vérification des champs obligatoires
            if (!empty($nom) && !empty($categorieNom) && !empty($etat) && $quantite > 0) {
                
                // 3. Récupération des IDs nécessaires via le Modèle
                $objetModel = new Objet();
                
                // ID Département (depuis la session utilisateur)
                $id_dep = $_SESSION['user']['id_dep'] ?? null;

                if ($id_dep) {
                    // Trouver l'ID Inventaire du département
                    $id_invent = $objetModel->getIdInventaireByDep($id_dep);
                    
                    // Trouver l'ID Catégorie (Attention : il faut que vos <option> correspondent aux noms en BDD)
                    // Sinon, utilisez des value="1", value="2" dans le HTML.
                    // Ici on suppose qu'on cherche l'ID via le nom envoyé par le select
                    $id_cat = $objetModel->getIdCategorieByNom($categorieNom);

                    // Si on n'a pas trouvé de catégorie exacte, on peut mettre une valeur par défaut ou une erreur
                    // Pour l'exemple, assurons-nous que la catégorie existe en BDD ou que le formulaire envoie l'ID directement.
                    // Si $id_cat est vide, c'est bloquant.
                    
                    if ($id_invent && $id_cat) {
                        // 4. Insertion
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

        $this->loadView('/chefDep/chefDepAddObj', $data);
    }
}

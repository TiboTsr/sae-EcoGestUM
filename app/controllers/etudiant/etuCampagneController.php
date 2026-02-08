<?php
require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Campagne.php';


class EtuCampagneController extends Controller
{

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id_user = $_SESSION['user']['id_user'] ?? 1;

        $campagneModel = new Campagne();
        $campagnes = $campagneModel->getAllCampagnes();

        $mesInscriptions = $campagneModel->getInscriptionsUser($id_user);

        $data = [
            'title' => 'Campagnes',
            'campagnes' => $campagnes,
            'mesInscriptions' => $mesInscriptions
        ];

        $this->loadView('/etudiant/etuCampagne', $data);
    }


    public function inscrire()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_SESSION['user']['id_user'])) {
                header('Location: index.php?page=loginLMU');
                exit();
            }

            $id_camp = $_POST['id_camp'] ?? null;
            $id_user = $_SESSION['user']['id_user'];

            if ($id_camp) {
                $campagneModel = new Campagne();
                $campagneModel->inscrire($id_user, $id_camp);

                header('Location: index.php?page=etuCampagne&action=index&success=1');
                exit();
            }
        }
    }

    public function desinscrire()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_camp = $_POST['id_camp'];
            $id_user = $_SESSION['user']['id_user'] ?? 1;

            $campagneModel = new Campagne();
            $campagneModel->desinscrire($id_user, $id_camp);

            header('Location: index.php?page=etuCampagne&action=index&msg=unsubscribed');
            exit();
        }
    }
}

<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Notification.php';

class ChefDepNotifController extends Controller {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']['id_user'])) {
            header('Location: index.php?page=loginLMU');
            exit();
        }

        $notificationModel = new Notification();
        $data = [
            'title' => 'Notifications',
            'message' => null,
            'message_type' => null,
            'historique' => []
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $objet = htmlspecialchars($_POST['objet'] ?? '');
            $corpsMessage = htmlspecialchars($_POST['message'] ?? '');
            $id_chef = $_SESSION['user']['id_user'];

            if (!empty($objet) && !empty($corpsMessage)) {
                
                $messageComplet = "[Objet: $objet] $corpsMessage";

                try {
                    $notificationModel->envoyerNotification($id_chef, $messageComplet);
                    $data['message'] = "Notifications envoyées avec succès aux étudiants et enseignants.";
                    $data['message_type'] = "success";
                } catch (Exception $e) {
                    $data['message'] = "Erreur lors de l'envoi : " . $e->getMessage();
                    $data['message_type'] = "error";
                }
            } else {
                $data['message'] = "Veuillez remplir l'objet et le message.";
                $data['message_type'] = "error";
            }
        }

        $data['historique'] = $notificationModel->getHistoriqueNotifications();

        $this->loadView('chefDep/chefDepNotif', $data);
    }
}

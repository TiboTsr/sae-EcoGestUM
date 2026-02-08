<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';
require_once __DIR__ . '/../../models/Objet.php';

class EtuEchangeController extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_user = $_SESSION['user']['id_user'] ?? null;

        $reservations = [];
        if ($id_user) {
            $objetModel = new Objet();
            $reservations = $objetModel->getMesReservations($id_user);
        }

        $data = [
            'title' => 'Echange d\'objet',
            'reservations' => $reservations,
        ];

        $this->loadView('/etudiant/etuEchange', $data);
    }
}

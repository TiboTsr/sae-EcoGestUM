<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';

class EnseignantNotifController extends Controller {
    public function index() {

        $data = [
            'title' => 'Notification',
        ];

        $this->loadView('/enseignant/enseignantNotif', $data);
    }
}

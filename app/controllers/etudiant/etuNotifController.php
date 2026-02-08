<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';

class EtuNotifController extends Controller {
    public function index() {

        $data = [
            'title' => 'Notification',
        ];

        $this->loadView('/etudiant/etuNotif', $data);
    }
}

<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';

class EnseignantCollabController extends Controller {
    public function index() {

        $data = [
            'title' => 'Collaboration',
        ];

        $this->loadView('/enseignant/enseignantCollab', $data);
    }
}

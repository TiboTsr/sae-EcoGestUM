<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';

class EnseignantBesoinsController extends Controller {
    public function index() {

        $data = [
            'title' => 'Signaler un besoin',
        ];

        $this->loadView('/enseignant/enseignantBesoins', $data);
    }
}

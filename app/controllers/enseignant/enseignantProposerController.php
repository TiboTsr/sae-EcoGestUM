<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';

class enseignantProposerController extends Controller {
    public function index() {

        $data = [
            'title' => 'Proposer un objet à recycler',
        ];

        $this->loadView('enseignant/enseignantProposer', $data);
    }
}

<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';

class EnseignantGuideController extends Controller {
    public function index() {

        $data = [
            'title' => 'Guide et bonnes pratiques',
        ];

        $this->loadView('/enseignant/enseignantGuide', $data);
    }
}

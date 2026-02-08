<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';

class EtuSignalerController extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'Signaler un objet',
        ];

        $this->loadView('/etudiant/etuSignaler', $data);
    }
}

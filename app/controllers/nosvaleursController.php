<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once 'core/View.php';

class nosvaleursController extends Controller
{

    public function index()
    {

        $data = [
            'title' => 'Nos valeurs',
        ];

        $this->loadView('nosvaleurs', $data);
    }
}

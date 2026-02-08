<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once 'core/View.php';

class tableaudebordController extends Controller
{

    public function index()
    {

        $data = [
            'title' => 'Tableau de bord',
        ];

        $this->loadView('tableaudebord', $data);
    }
}

<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once 'core/View.php';

class LoginController extends Controller
{

    public function index()
    {

        $data = [
            'title' => 'Page de connexion',
        ];

        $this->loadView('login', $data);
    }
}

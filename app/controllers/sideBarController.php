<?php

class SidebarController
{
    public function afficher()
    {
        include __DIR__ . '/../views/sidebar.php';
    }
}

$controller = new SidebarController();
$controller->afficher();
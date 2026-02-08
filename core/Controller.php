<?php
class Controller {
    protected function loadView($viewName, $data = []) {
        // Déléguons le rendu à View::render pour gérer la casse (Linux)
        if (!class_exists('View')) {
            require_once __DIR__ . '/View.php';
        }
        View::render($viewName, $data);
    }
}
?>

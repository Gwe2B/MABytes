<?php

namespace App\Controller;

abstract class Controller {
    private $twigEnvironment = null;

    public function __construct() {
        $twigLoader = new \Twig\Loader\FilesystemLoader(VIEWS_DIR);
        $this->twigEnvironment = new \Twig\Environment($twigLoader, TWIG_SETTINGS);
    }

    protected function render(string $viewName, array $pageContent = array()): void {
        echo $this->twigEnvironment->render($viewName, $pageContent);
    }
}
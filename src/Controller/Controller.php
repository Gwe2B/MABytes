<?php

namespace App\Controller;

/**
 * The controller main class.
 * All the controllers class must implement this one.
 * 
 * @author Guiraud Gwenaël
 * @version 2
 * @abstract
 */
abstract class Controller {
    /**
     * The twig instance for templating
     * @var \Twig\Environment
     */
    private $twigEnvironment = null;

    /**
     * Class constructor
     * 
     * Simply initialize the class attributes.
     */
    public function __construct() {
        $twigLoader = new \Twig\Loader\FilesystemLoader(VIEWS_DIR);
        $this->twigEnvironment = new \Twig\Environment($twigLoader, TWIG_SETTINGS);
    }

    /**
     * Render the requested template using the the templating system
     * @param string $viewName The view filename
     * @param array[mixed] $pageContent The content to fill the page
     * @return void 
     */
    protected function render(string $viewName, array $pageContent = array()): void {
        echo $this->twigEnvironment->render($viewName, $pageContent);
    }
}
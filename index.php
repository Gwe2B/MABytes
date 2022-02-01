<?php

define('ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('VIEWS_DIR', ROOT.'views'.DIRECTORY_SEPARATOR);

define(
    'TWIG_SETTINGS',
    array(
        'cache' => false, // DEV -> false, PROD -> ROOT.'cache'.DIRECTORY_SEPARATOR
        'debug' => true,  // DEV -> true, PROD -> false
        'autoescape' => 'html'
    )
);

require ROOT."vendor".DIRECTORY_SEPARATOR."autoload.php";

$twigLoader = new Twig\Loader\FilesystemLoader(VIEWS_DIR);
$twigEnvironment = new Twig\Environment($twigLoader, TWIG_SETTINGS);

$template = $twigEnvironment->load('acceuil.twig');

echo $template->render(array('text' => 'Hello World!!'));
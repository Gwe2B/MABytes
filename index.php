<?php
ini_set('display_errors', 1); // DEV -> 1, PROD -> 0

/* -------------------------- Constants definition -------------------------- */
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

/* -------------------------------------------------------------------------- */
/*                            Router Initialisation                           */
/* -------------------------------------------------------------------------- */
$router = new App\Router\Router(
    (isset($_GET['url']) && !empty($_GET['url'])) ? $_GET['url'] : '/'
);

/* ------------------------------- GET routes ------------------------------- */
$router->get('/carteinterractive', 'CarteInterractive#show');
$router->get('/information', 'Information#show');
$router->get('/formulaire', 'Formulaire#show');
$router->get('/accueil', 'Index#show');


// Running the router
$router->run();
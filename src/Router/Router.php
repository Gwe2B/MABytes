<?php

namespace App\Router;

/**
 * Router system main class
 * Manage the different routes and HTTP methods
 * @author Gwenaël Guiraud
 * @version 1
 */
class Router {
    /**
     * The requested URL
     * @var string
     */
    private $url;

    /**
     * The existing routes
     * @var array[Route]
     */
    private $routes = array();

    /**
     * Class constructor
     * @param string $url The requested URL
     */
    public function __construct(string $url) {
        $this->url = $url;
    }

    /**
     * Add a GET route
     * @see self::add()
     */
    public function get(string $path, mixed $callable): Route {
        return $this->add($path, $callable, 'GET');
    }

    /**
     * Add a POST route
     * @see self::add()
     */
    public function post(string $path, mixed $callable): Route {
        return $this->add($path, $callable, 'POST');
    }

    /**
     * Add a route to the router
     * @param string $path The url of the route
     * @param string|callable $callable The action to be called
     * @param string $method The HTTP method of the route
     * @return Route Return the newly added route to make method chaining
     */
    private function add(string $path, mixed $callable, string $method): Route {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;

        return $route;
    }

    /**
     * The running method of the router system
     * @return mixed The route's callable result
     * @throws RouterException If the requested URL doesn't exist for the
     *  requested method or if there is no existing route for the given URL
     */
    public function run() {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException(
                'The http '.$_SERVER['REQUEST_METHOD'].' method does not exist
                for the given url '.$this->url
            );
        }

        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if($route->match($this->url)) {
                return $route->call();
            }
        }

        throw new RouterException(
            'No matching routes for '.((empty($this->url))?'/':$this->url)
        );
    }
}

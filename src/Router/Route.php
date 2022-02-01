<?php

namespace App\Router;

class Route {
    const CONTROLLER_NAMESPACE = "App\\Controller\\";
    const CONTROLLER_SUFIXE = "Controller";

    private $path;
    private $callable;
    private $matches = array();
    private $params = array();

    /**
     * Create the route
     * @param string $path The path corresponding to the route
     * @param string|callable $callable The action to be called
     */
    public function __construct(string $path, string|callable $callable) {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    /**
     * Permit to specify a pattern to respect for a given parameter
     * @param string $param The parameter to be checker
     * @param string $regex The pattern to by respected by the parameter
     * @return Route Return the current object to make method chaining
     */
    public function with(string $param, string $regex): Route {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    /**
     * Check if the given url correspond to the route
     * @param string $url The url to be checked
     * @return bool Return true if it correspond, otherwise return false
     */
    public function match(string $url): bool {
        $result = false;

        $url = trim($url, '/');
        $pathCp = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$pathCp$#i";

        if(preg_match($regex, $url, $matches)) {
            $result = true;
            array_shift($matches);
            $this->matches = $matches;
        }

        return $result;
    }

    private function paramMatch(array $match): string {
        $result = '([^/]+)';
        if(isset($this->params[$match[1]])) {
            $result = '('.$this->params[$match[1]].')';
        }

        return $result;
    }

    /**
     * Method called by Router::run() when the route is used
     * @return mixed The result of the callable object
     * @see App\Router\Router::run()
     */
    public function call(): mixed {
        if(is_string($this->callable)) {
            $CtrlParams = explode('#', $this->callable);
            $controller = self::CONTROLLER_NAMESPACE.$CtrlParams[0].self::CONTROLLER_SUFIXE;
            $controller = new $controller;

            return call_user_func_array([$controller, $CtrlParams[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function getUrl(array $params): string {
        $pathCp = $this->path;
        foreach($params as $k => $v) {
            $pathCp = str_replace(":$k", $v, $pathCp);
        }

        return $pathCp;
    }
}
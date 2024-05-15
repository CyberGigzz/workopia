<?php

namespace Framework;

use App\controllers\ErrorController;

class Router {
    protected $routes = [];

    /**
     * Add a new route
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     * @param array $middleware
     * 
     * @return void
     */
    public function registerRoute($method, $uri, $action) {
        list($controller, $controllerMethod) = explode("@", $action);
        // inspect($controllerMethod);
        // inspectAndDie($controller);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     
     * @return void
     */
    public function get($uri, $controller) {
        $this->registerRoute('GET', $uri, $controller);
    }

    /**
     * Add a POST route
     * 
     * @param string $uri
     * @param string $controller
     
     * @return void
     */
    public function post($uri, $controller) {
        $this->registerRoute('POST', $uri, $controller);
    }

    /**
     * Add a PUT route
     * 
     * @param string $uri
     * @param string $controller
     
     * @return void
     */
    public function put($uri, $controller) {
        $this->registerRoute('PUT', $uri, $controller);
    }

    /**
     * Add a DELETE route
     * 
     * @param string $uri
     * @param string $controller
     
     * @return void
     */
    public function delete($uri, $controller) {
        $this->registerRoute("DELETE", $uri, $controller);
    }

    /**
     * Route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri) {
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        foreach ($this->routes as $route) {

            // Split the current URI into segments
            $uriSegments = explode('/', trim($uri, '/'));
            inspect($uriSegments);

            // Split the route URI into segments
            $routeSegments = explode('/', trim($route['uri'], '/'));
            inspect($routeSegments);

            $match = true;

            // Check if the number of segments matches
            if (count($uriSegments) === count($routeSegments) && strtoupper($route['method']) === strtoupper($requestMethod)) {
                $params = [];

                echo "hi";
                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    // If the uri's do not match and there is no param
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    // Check for the param and add to $params array
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }
            }

            // if ($route["uri"] === $uri && $route["method"] === $method) {
            //     $controller = 'App\\controllers\\' . $route["controller"];
            //     $controllerMethod = $route["controllerMethod"];
            //     $controllerInstance = new $controller();
            //     $controllerInstance->$controllerMethod();

            //     return;
            // }
        }
        ErrorController::notFound();
    }
}
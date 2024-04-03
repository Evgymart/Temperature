<?php
declare(strict_types=1);
namespace Alignant\Temperature\router;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Router
{
    public function __construct()
    {
    }

    private array $routes;

    public function addPost(string $className, string $method)
    {
        $uri = $this->formUri($className, $method);
        $this->routes[$uri] = [
            'method' => 'POST',
            'class' => $className,
            'call' => $method,
        ];
    }

    public function addGet(string $className, string $method, string $param = null)
    {
        $uri = $this->formUri($className, $method);
        $this->routes[$uri] = [
            'method' => 'GET',
            'class' => $className,
            'call' => $method,
            'param' => $param
        ];
    }

    public function init(string $root)
    {
        $routesFile = $root . DIRECTORY_SEPARATOR . '/app/config/routes.php';
        $router = $this;
        require_once $routesFile;
    }

    public function route(Request $request): Response
    {
        $routeData = $this->getRouteData($request->getRequestUri());
        if (empty($routeData)) {
            throw new HttpException(403, 'Not found');
        }

        $route = $routeData['route'];
        $method = $route['method'] ?? '';
        if ($request->getMethod() != $method) {
            throw new HttpException(403, 'Bad method');
        }

        $controllerClass = $route['class'] ?? null;
        if (is_null($controllerClass)) {
            throw new HttpException(502, 'Internal class error');
        }

        $controller = new $controllerClass($request);
        $func = $route['call'] ?? null;
        if (!method_exists($controller, $func)) {
            throw new HttpException(502, 'Internal class error');
        }

        $param = $routeData['param'] ?? null;
        if (is_null($param)) {
            $response = $controller->{$func}();
        } else {
            $response = $controller->{$func}($param);
        }

        if (get_class($response) != Response::class) {
            throw new HttpException(502, 'Internal class error');
        }

        return $response;
    }

    private function formUri(string $className, string $method): string
    {
        $className = substr($className, strrpos($className, '\\') + 1);
        $route = substr($className, 0, strrpos($className, 'Controller'));
        return strtolower('/' . $route . '/' . $method);
    }

    private function getRouteData(string $uri): array
    {
        $uri = strtok($uri, '?');;
        $route = $this->routes[$uri] ?? null;
        if (!is_null($route)) {
            return [
                'route' => $route,
                'param' => null,
            ];
        }

        $newUri = substr($uri, 0, strrpos($uri, '/'));
        $param = substr($uri, strrpos($uri, '/') + 1);
        if (!empty($this->routes[$newUri]['param'])) {
            return [
                'route' => $this->routes[$newUri],
                'param' => $param,
            ];
        }

        return [];
    }
}

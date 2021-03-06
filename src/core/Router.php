<?php

namespace edustef\mvcFrame;

use edustef\mvcFrame\exceptions\NotFoundException;

class Router
{
  /**
   * This stores an array of arrays with the format 
   */
  protected array $routes = [];
  public Request $request;
  public Response $response;

  public function __construct(Request $request, Response $response)
  {
    $this->response = $response;
    $this->request = $request;
  }

  public function get($path, $callback)
  {
    $this->routes[$this->request::GET][$path] = $callback;
  }

  public function post($path, $callback)
  {
    $this->routes[$this->request::POST][$path] = $callback;
  }

  public function put($path, $callback)
  {
    $this->routes[$this->request::PUT][$path] = $callback;
  }

  public function patch($path, $callback)
  {
    $this->routes[$this->request::PATCH][$path] = $callback;
  }

  public function delete($path, $callback)
  {
    $this->routes[$this->request::DELETE][$path] = $callback;
  }

  /**
   * Will resolve the method and path of the REQUEST
   * and will create the controller and run it's method referenced by the callback.
   * @throws NotFoundException; 
   */
  public function resolve(): string
  {
    $method = $this->request->method();

    $resolvedRoute = $this->resolveRoute();
    $callback = $this->routes[$method][$resolvedRoute['regPath']] ?? false;

    //create instance of controller
    if (is_array($callback)) {
      $controller = new $callback[0]();
      Application::$app->controller = $controller;
      $controller->action = $callback[1];
      $callback[0] = $controller;
    }

    return call_user_func($callback, $this->request, $this->response, $resolvedRoute['params']);
  }

  private function resolveRoute()
  {
    $pathMatches = true;

    $method = $this->request->method();
    $pathArr = explode('/', $this->request->getPath());
    array_shift($pathArr);

    if (is_null($this->routes[$method])) {
      throw new NotFoundException();
    }

    foreach (array_keys($this->routes[$method]) as $registeredPath) {

      $pathMatches = true;
      $params = [];
      $registeredPathArr = explode('/', $registeredPath);
      array_shift($registeredPathArr);

      if (count($registeredPathArr) !== count($pathArr)) {
        $pathMatches = false;
      } else {
        foreach ($registeredPathArr as $pos => $registeredPathFragment) {
          if (substr($registeredPathFragment, 0, 1) === ':') {
            $params[substr($registeredPathFragment, 1)] = $pathArr[$pos];
          } else if ($registeredPathFragment !== $pathArr[$pos]) {
            $pathMatches = false;
            break;
          }
        }
      }
      if ($pathMatches !== false) {
        return ['regPath' => $registeredPath, 'params' => $params];
      }
    }

    throw new NotFoundException();
  }
}

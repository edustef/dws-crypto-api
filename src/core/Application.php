<?php

namespace edustef\mvcFrame;

class Application
{
  public static Application $app;

  public Router $router;
  protected Request $request;
  protected Response $response;
  // Controller is instanciated in Router class 
  public ?Controller $controller = null;

  public ?\MongoDB\Database $database = null;

  public function __construct(array $config)
  {
    self::$app = $this;

    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);

    if (isset($config['db'])) {
      $this->database = (new Database($config['db']))->getDB();
    }
  }

  public function run()
  {
    try {
      echo $this->router->resolve();
    } catch (\Exception $e) {
      echo $this->response->json($e->getMessage(), $this->response::NOT_FOUND);
    }
  }

  public function getDB(): \MongoDB\Database
  {
    return $this->database;
  }
}

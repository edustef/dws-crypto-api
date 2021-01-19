<?php

namespace api\controllers;

use edustef\mvcFrame\Controller;
use edustef\mvcFrame\Request;
use edustef\mvcFrame\Response;
use edustef\mvcFrame\Application;

class TestController extends Controller
{

  public function resolve(Request $request, Response $response)
  {
    $path = explode('/', $request->getPath());
    $method = $request->method();
    $resource = array_shift($path);

    return $response->json(['method' => $method]);
  }

  public function getTests(Request $request, Response $response)
  {
    $results = [];
    $db = Application::$app->getDB();

    $cursor = $db->test->find();

    foreach ($cursor as $test) {
      $results[] = $test;
    }

    return $response->json($results);
  }

  public function getTest(Request $request, Response $response, $params)
  {
    $db = Application::$app->database;

    $result = $db->test->findOne(['name' => 'test1']);

    return $response->json($result);
  }
}

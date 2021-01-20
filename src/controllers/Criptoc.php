<?php

namespace api\controllers;

use edustef\mvcFrame\Controller;
use edustef\mvcFrame\Request;
use edustef\mvcFrame\Response;
use edustef\mvcFrame\Application;

class Criptoc extends Controller
{
  public function getCriptoc(Request $request, Response $response)
  {
    $results = [];
    $db = Application::$app->getDB();

    $cursor = $db->criptoc->find();

    foreach ($cursor as $criptoc) {
      $results[] = $criptoc;
    }

    return $response->json($results);
  }

  public function getOneCriptoc(Request $request, Response $response, $params)
  {
    $db = Application::$app->database;

    $result = $db->criptoc->findOne(['symbol' => $params['id']]);

    return $response->json($result);
  }

  public function postCriptoc(Request $request, Response $response, $params)
  {
    $db = Application::$app->database;

    $result = $db->criptoc->findOne(['name' => 'test1']);

    return $response->json($result, $response::CREATED);
  }
}

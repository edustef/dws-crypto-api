<?php

namespace api\models;

use edustef\mvcFrame\DatabaseModel;
use edustef\mvcFrame\Application;

class Criptoc extends DatabaseModel
{
  public static function collection()
  {
    $collection = Application::$app->database->getDB()->criptoc;
    return $collection;
  }

  public static function changeCriptocValue($symbol, $value)
  {
    $collection = self::collection();
    $criptoc = $collection->findOne(['symbol' => $symbol]);
    $result = $collection->updateOne(
      ['symbol' => $symbol],
      ['$set' => ['price' => $criptoc->price + $value]]
    );

    return $result->getModifiedCount() > 0;
  }

  public static function getTopCriptoc()
  {
    $collection = self::collection();
    $results = [];

    $cursor = $collection->find([], ['sort' => ['price' => -1]]);

    foreach ($cursor as $criptoc) {
      $results[] = $criptoc;
    }

    return $results;
  }
}

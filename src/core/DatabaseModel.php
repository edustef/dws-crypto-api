<?php

namespace edustef\mvcFrame;

abstract class DatabaseModel extends Model
{
  abstract public static function collectionName(): string;

  public function insertOne($data)
  {
    $collection = Application::$app->database->${static::collectionName()};

    $collection->insertOne($data);
  }

  public static function find(array $where)
  {
    $collection = Application::$app->database->${static::collectionName()};
    $results = [];

    $cursor = $collection->find();

    foreach ($cursor as $criptoc) {
      $results[] = $criptoc;
    }

    return $results;
  }

  public static function findOne(array $where)
  {
    $collection = Application::$app->database->${static::collectionName()};
    return $collection->findOne($where);
  }

  public static function deleteOne(array $where)
  {
    $collection = Application::$app->database->${static::collectionName()};
    return $collection->deleteOne($where);
  }

  public function updateOne($where, $setData)
  {
    $collection = Application::$app->database->${static::collectionName()};
    return $collection->updateOne([$where, '$set' => $setData]);
  }
}

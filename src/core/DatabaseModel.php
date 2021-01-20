<?php

namespace edustef\mvcFrame;

abstract class DatabaseModel extends Model
{
  abstract public static function collectionName(): string;

  public function insertOne()
  {
  }

  public static function findOne(array $where)
  {
  }

  public static function find(array $where = null)
  {
    $collectionName = static::collectionName();
  }

  public static function deleteOne(array $where)
  {
    $collectionName = static::collectionName();
  }

  public function update()
  {
    $collectionName = static::collectionName();
  }

  public static function prepare(string $mysql)
  {
    return Application::$app->database->pdo->prepare($mysql);
  }
}

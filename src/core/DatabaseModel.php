<?php

namespace edustef\mvcFrame;

abstract class DatabaseModel extends Model
{
  abstract public static function collection();

  public static function insertOne($data)
  {
    $collection = static::collection();

    $result = $collection->insertOne($data);
    if ($result->getInsertedCount() > 0) {
      return true;
    }

    return false;
  }

  public static function find(array $where = [])
  {
    $collection = static::collection();
    $results = [];

    $cursor = $collection->find($where);

    foreach ($cursor as $criptoc) {
      $results[] = $criptoc;
    }

    return $results;
  }

  public static function findOne(array $where)
  {
    $collection = static::collection();
    return $collection->findOne($where);
  }

  public static function deleteOne(array $where)
  {
    $collection = static::collection();
    $result = $collection->deleteOne($where);
    return $result->getDeletedCount() > 0;
  }

  public static function updateOne(array $where, array $setData)
  {
    $collection = static::collection();
    return $collection->updateOne($where, ['$set' => $setData]);
  }
}

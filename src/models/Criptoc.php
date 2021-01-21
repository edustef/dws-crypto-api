<?php

use edustef\mvcFrame\DatabaseModel;

class Criptoc extends DatabaseModel
{
  public $name;
  public $symbol;
  public $description;
  public $precio;
  public $change_24h;
  public $cap;

  public function __construct($data)
  {
    $this->loadData($data);
  }

  public static function collectionName(): string
  {
    return 'criptoc';
  }
}

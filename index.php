<?php
ini_set('display_errors', 'on');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Allow-Access-Origin: application/json');

require_once __DIR__ . '/vendor/autoload.php';

use api\controllers\Criptoc;
use edustef\mvcFrame\Application;

if (file_exists(__DIR__ . '/.env')) {
  $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();
}

$config = [
  'db' => [
    'dbname' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'db_local' => $_ENV['DB_LOCAL'] === 'true' ? true : false
  ],
];

$app = new Application($config);

$app->router->get('/criptoc', [Criptoc::class, 'getCriptoc']);
$app->router->get('/criptoc/:id', [Criptoc::class, 'getOneCriptoc']);
$app->router->post('/criptoc', [Criptoc::class, 'postCriptoc']);

$app->router->put('/criptoc/:id', [Criptoc::class, 'resolve']);
$app->router->put('/criptoc/up/:id', [Criptoc::class, 'resolve']);
$app->router->put('/criptoc/down/:id', [Criptoc::class, 'resolve']);

$app->run();

<?php

namespace edustef\mvcFrame;

class Response
{
  public const OK = 200;
  public const CREATED = 201;
  public const NO_CONTENT = 204;
  public const BAD_REQUEST = 400;
  public const FORBIDDEN = 403;
  public const NOT_FOUND = 404;
  public const NOT_ALLOWED = 405;
  public const INTERAL_SERVER = 500;

  public function setStatusCode(int $code)
  {
    http_response_code($code);
  }

  public function redirect(string $path)
  {
    header('Location: ' . $path);
  }

  public function json($data, $statusCode = self::OK, $message = null)
  {
    $this->setStatusCode($statusCode);
    $message = $message ?? $this->getMessage($statusCode);
    $result = [
      'status' => $statusCode,
      'message' => $message,
      'data' => $data
    ];

    if (is_null($data)) {
      unset($result['data']);
    }

    return json_encode($result);
  }

  public function getMessage($statusCode)
  {
    $messages = [
      self::OK => 'Sent succesfully.',
      self::CREATED => 'Created succesfully.',
      self::FORBIDDEN => 'You don\'t have acces to this resource.',
      self::NOT_FOUND => 'Resource not found.',
      self::NO_CONTENT => '',
      self::BAD_REQUEST => 'The request was not valid!',
      self::INTERAL_SERVER => 'Don\'t worry. It is not your fault. It is an internal server error.'
    ];

    return $messages[$statusCode];
  }
}

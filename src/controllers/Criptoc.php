<?php

namespace api\controllers;

use api\models\Criptoc as CriptocModel;
use edustef\mvcFrame\Controller;
use edustef\mvcFrame\Request;
use edustef\mvcFrame\Response;

class Criptoc extends Controller
{
  public function getCriptoc(Request $request, Response $response)
  {
    return $response->json(CriptocModel::find());
  }

  public function getTopCriptoc(Request $request, Response $response)
  {
    return $response->json(CriptocModel::getTopCriptoc());
  }



  public function getOneCriptoc(Request $request, Response $response, $params)
  {
    $result = CriptocModel::findOne(['symbol' => $params['id']]);
    if ($result) {
      return $response->json($result);
    }

    return $response->json(null, $response::NOT_FOUND);
  }

  public function postCriptoc(Request $request, Response $response)
  {
    $body = $request->getBody();
    $isUnique = is_null(CriptocModel::findOne(['symbol' => $body['symbol']]));
    if ($isUnique) {
      $result = CriptocModel::insertOne($body);
      $resCode = $result ? $response::CREATED : $response::INTERAL_SERVER;
      return $response->json(null, $resCode);
    }
    return $response->json(null, $response::BAD_REQUEST, 'Dublicate entry. Cannot fulfill this request.');
  }

  public function deleteCriptoc(Request $req, Response $res, $params)
  {
    $result = CriptocModel::deleteOne(['symbol' => $params['id']]);
    if ($result) {
      return $res->json(null, $res::OK, 'Resource deleted successfully');
    }

    return $res->json(null, $res::NOT_FOUND, 'Resource was not found');
  }


  public function updateCriptoc(Request $req, Response $res, $params)
  {
    $where = ['symbol' => $params['id']];
    $criptoc = CriptocModel::findOne($where);
    if ($criptoc) {
      CriptocModel::updateOne($where, $req->getBody());
      return $res->json(null, $res::OK, 'Updated successfully');;
    }

    return $res->json(null, $res::NOT_FOUND);
  }

  public function upCriptocValue(Request $req, Response $res, $params)
  {
    $isUpdated = CriptocModel::changeCriptocValue($params['id'], 10);
    if ($isUpdated) {
      return $res->json(null, $res::OK, 'Resource updated successfully');
    }
    return $res->json(null, $res::NOT_FOUND);
  }
  public function downCriptocValue(Request $req, Response $res, $params)
  {
    $isUpdated = CriptocModel::changeCriptocValue($params['id'], -10);
    if ($isUpdated) {
      return $res->json(null, $res::OK, 'Resource updated successfully');
    }
    return $res->json(null, $res::NOT_FOUND);
  }
}

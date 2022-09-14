<?php 
namespace Usuarium;

use Models\ApiClient;


class ApiClientController extends BaseController
{
  public function index()
  {
    $api_clients = ApiClient::all();
    echo json_encode($api_clients);
  }

}

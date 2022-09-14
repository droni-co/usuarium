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
  public function store() {
    $apiClient = new ApiClient();
    $apiClient->name = $this->request->name;
    $apiClient->secret = $this->getSecret(10);
    $apiClient->save();
    echo json_encode($apiClient);

  }
  public function middleware() {
    $client_id = $this->request->header('client_id');
    $client_secret = $this->request->header('client_secret');

    $apiClient = ApiClient::where('id', $client_id)->where('secret', $client_secret)->first();
    if (!$apiClient) {
      http_response_code(401);
      echo json_encode([
        'status' => 'error',
        'message' => 'Invalid client_id or client_secret'
      ]);
      exit;
    }
  }
  private function getSecret($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}

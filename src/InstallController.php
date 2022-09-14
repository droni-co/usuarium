<?php 
namespace Usuarium;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Models\User;


class InstallController extends BaseController
{
  public function check()
  {
    try {
      User::first();
      echo json_encode([
        "status" => "ok",
        "message" => "Database already migrated"
      ]);
      
    } catch (\Exception $e) {
      echo json_encode([
        "status" => "error",
        "message" => "Database conection problem or not migrated"
      ]);
    }
  }
  public function migrate()
  {
    try {
      DB::schema()->create('users', function ($table) {
        $table->increments('id');
        $table->string('email')->unique();
        $table->string('first_name');
        $table->string('last_name')->nullable();
        $table->string('avatar')->nullable();
        $table->timestamps();
      });
      echo json_encode([
        "status" => "ok",
        "message" => "Database migrated"
      ]);
    } catch (\Exception $e) {
      echo json_encode([
        "status" => "error",
        "message" => "Database conection problem or already migrated"
      ]);
    }
  }

  public function fetcher()
  {
    $this->getRecords();
  }
  private function getRecords($page=1) {
    $client = new Client();
    $response = $client->get('https://reqres.in/api/users?page='.$page);
    $json = json_decode($response->getBody());
    dd($json);
  }
}

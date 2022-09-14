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
      // create table for users
      DB::schema()->create('users', function ($table) {
        $table->increments('id');
        $table->string('email')->unique();
        $table->string('first_name');
        $table->string('last_name')->nullable();
        $table->string('avatar')->nullable();
        $table->timestamps();
      });
      // create table for api clients
      DB::schema()->create('api_clients', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->string('secret');
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
    $users = User::count();
    $per_page = 6;
    $page = ceil($users / $per_page) + 1;

    $client = new Client();
    $response = $client->get('https://reqres.in/api/users?page='.$page);
    // if response is ok
    if($response->getStatusCode() == 200) {
      $data = json_decode($response->getBody());
      // insert records
      foreach($data->data as $user) {
        $user = User::create([
          'email' => $user->email,
          'first_name' => $user->first_name,
          'last_name' => $user->last_name,
          'avatar' => $user->avatar
        ]);
      }
      echo json_encode([
        "status" => "ok",
        "message" => "Records inserted from page ".$page
      ]);
    }
  }
}

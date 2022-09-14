<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class ApiClient extends Model {

  protected $table = 'api_clients';
  protected $fillable = ['email', 'first_name', 'last_name', 'avatar'];

}
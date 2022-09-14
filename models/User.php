<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model {

  protected $table = 'users';
  protected $fillable = ['email', 'first_name', 'last_name', 'avatar'];
  protected $hidden = ['created_at', 'updated_at'];

}
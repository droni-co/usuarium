<?php 
namespace Usuarium;

use Illuminate\Http\Request;

class BaseController {
  public $request = null;

  public function __construct() {
    $this->request = Request::capture();
  }
}
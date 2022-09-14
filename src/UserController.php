<?php 
namespace Usuarium;
use Models\User;
use \Illuminate\Pagination\Paginator;

class UserController extends BaseController {
  public function index() {
    $page = $this->request->input('page', 1);
    $limit = 5;
    $offset = ($page * $limit) - $limit;
    $total = User::count();
    $users = User::offset($offset)->limit($limit)->get();
    echo json_encode([
      'page' => $page,
      'total' => $total,
      'per_page' => $limit,
      'data' => $users
    ]);
  }
  public function show($id) {
    $user = User::find($id);
    echo json_encode($user);
  }
}
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
  public function store() {
    $user = new User();
    $user->first_name = $this->request->first_name;
    $user->last_name = $this->request->last_name;
    $user->email = $this->request->email;
    $user->avatar = $this->request->avatar;
    $user->save();
    echo json_encode($user);
  }
  public function update() {
    $user = User::find($this->request->id);
    $user->first_name = $this->request->first_name;
    $user->last_name = $this->request->last_name;
    $user->email = $this->request->email;
    $user->avatar = $this->request->avatar;
    $user->save();
    echo json_encode($user);
  }
}
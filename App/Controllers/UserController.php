<?php

namespace App\Controllers;

use App\Helper\Session;
use App\Models\User;
use \Core\View;
use \Core\Controller;


// userController controller
class UserController extends Controller
{
    public function __construct()
    {
        $session = Session::getInstance();
        if (!$session->isSignedIn()){
            header('Location: /login');
        }
    }
    
    public function index()
    {
        $users = User::orderBy('id','desc')->get();

        View::renderTemplate('Admin/Users/index.html', ['users' => $users]);
    }

    public function create()
    {
        View::renderTemplate('Admin/Users/create.html');
    }

    public function store()
    {
        $user = new User();
        $user->fullname = $_POST['fullname'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        $user->save();

        header('Location: /admin/users');
    }

    public function edit()
    {
        $id = $_GET['id'];
        $user = User::findOrFail($id);

        View::renderTemplate('Admin/Users/edit.html', ['user'=>$user]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $user = User::findOrFail($id);
        $user->fullname = $_POST['fullname'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        $user->update();

        header('Location: /admin/users');
    }

    public function destroy()
    {
        $id = $_GET['id'];
        $user = User::findOrFail($id);
        $user->delete();

        header('Location: /admin/users');
    }
}

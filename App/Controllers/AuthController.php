<?php

namespace App\Controllers;

use App\Helper\Session;
use App\Models\User;
use \Core\View;
use \Core\Controller;

class AuthController extends Controller
{
    public function loginForm()
    {
        $session = Session::getInstance();
        $message = '';
        if (!empty($session->message)) {
            $message = $session->message;
        }

        if (isset($_SESSION['userId'])) {
            header('Location: /');
            exit;
        }

        View::renderTemplate('/UI/login.html', ['message' => $message]);
    }


    // public function store()
    // {
    //     $email = $_POST['email'];
    //     $password = $_POST['password'];
    //     $user = User::where('email', $email)->where('password', $password)->latest()->first();
    //     $session = Session::getInstance();

    //     if ($user) {
    //         $session->login($user);
    //         header('Location: /bulletins');
    //         exit;
    //     }

    //     $session->message("Your email or password is incorrent");
    //     header('Location: /login');
    //     exit;
    // }


    public function store()
    {
        $email = $_POST['email'];
        $password = $_POST['password']; 
        $session = Session::getInstance();

        if (empty($email) || empty($password)) {
            $session->message("Ju lutem plotësoni të dhënat tuaja.");
            header('Location: /login');
            exit;
        }

        $user = User::where('email', $email)->where('password', $password)->latest()->first();

        if ($user) {
            $session->login($user);
            header('Location: /admin/bulletins');
            exit;
        }

        $session->message("Email-i ose fjalëkalimi juaj është i pasaktë");
        header('Location: /login');
        exit;
    }


    public function logout()
    {
        $session = Session::getInstance();
        if (!$session->isSignedIn()) {
            header('Location: /login');
            exit;
        }

        $session->logout();
        header('Location: /');
        exit;
    }
}


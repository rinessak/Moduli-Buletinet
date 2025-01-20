<?php

namespace App\Controllers;

use App\Helper\Session;
use App\Models\Faculty;
use \Core\View;
use \Core\Controller;

/**
 * FacultyController controller
 */
class FacultyController extends Controller
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
        $faculties = Faculty::orderBy('id','DESC')->get();

        View::renderTemplate('Admin/Faculties/index.html', ['faculties' => $faculties]);
    }

    public function create()
    {
        View::renderTemplate('Admin/Faculties/create.html');
    }

    public function store()
    {

        Faculty::create($_POST); 

        header("Location: /Admin/faculties");
    }

    public function show()
    {

    }

    public function edit()
    {
        $faculty = Faculty::find($_GET['id']);

        View::renderTemplate('Admin/Faculties/edit.html', ['faculty' => $faculty]);
    }

    public function update()
    {
        $faculty = Faculty::find($_POST['id']);
        $faculty->name = $_POST['name'];
        $faculty->save();

        header("Location: /Admin/faculties");
    }

    public function destroy()
    {
        $faculty = Faculty::find($_GET['id']);
        $faculty->delete();

        header("Location: /Admin/faculties");
    }
}

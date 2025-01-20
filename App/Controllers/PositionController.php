<?php

namespace App\Controllers;

use App\Helper\Session;
use App\Models\Faculty;
use App\Models\Position;
use \Core\View;
use \Core\Controller;

/**
 * PositionController controller
 */
class PositionController extends Controller
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
        $faculties = Faculty::orderBy('name')->get();
        $positions = Position::orderBy('position','ASC')->get();

        View::renderTemplate('admin/positions/index.html', ['positions' => $positions, 'faculties' => $faculties]);
    }

    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        View::renderTemplate('admin/positions/create.html', ['faculties' => $faculties]);
    }

    public function store()
    {

        $position = new Position();
        $position->faculty_id = $_POST['faculty_id'];
        $position->position = $_POST['position'];
        $position->description = $_POST['description'];
        $position->save();

        header("Location: /admin/positions");
    }

    public function show()
    {

    }

    public function edit()
    {
        $id = $_GET['id'];
        $faculties = Faculty::orderBy('name')->get();
        $position = Position::findOrFail($id);
        View::renderTemplate('admin/positions/edit.html', ['position' => $position, 'faculties' => $faculties]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $position = Position::findOrFail($id);
        $position->faculty_id = $_POST['faculty_id'];
        $position->position = $_POST['position'];
        $position->description = $_POST['description'];
        $position->save();

        header("Location: /admin/positions");
    }

    public function destroy()
    {
        $id = $_GET['id'];
        $position = Position::findOrFail($id);
        $position->delete();

        header("Location: /admin/positions");
    }
}

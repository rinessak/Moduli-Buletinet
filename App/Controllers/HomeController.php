<?php

namespace App\Controllers;

use \Core\View;
use App\Helper\Session;
use App\Models\Bulletin;
use App\Models\Faculty;
use App\Models\Position;
use \Core\Controller;
use Carbon\Carbon;

/**
    * HomeController controller
 */
class HomeController extends Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function admin()
    {
        $session = Session::getInstance();
        if (!$session->isSignedIn()){
            header('Location: /login');
        }
        View::renderTemplate('Admin/Dashboard/index.html');
    }

    public function index()
    {
        $now = Carbon::now();
        $fifteenDaysAgo = $now->copy()->subDays(2);

        $faculties = Faculty::orderBy('name')->get();
        $positions = Position::orderBy('position')->get();
        $bulletins = Bulletin::where('published_at', '>=', $fifteenDaysAgo) 
                            ->where('published_at', '<=', $now)
                            ->orderBy('published_at', 'desc')
                            ->get();

        View::renderTemplate('UI/index.html', ['bulletins' => $bulletins, 'faculties' => $faculties, 'positions' => $positions]);
        // dd($bulletin);
    }        

    public function login()
    {
        View::renderTemplate('UI/login.html');
    }

}

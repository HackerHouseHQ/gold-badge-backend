<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use App\Department;
use App\DepartmentBadge;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usercount = User::count();
        $data['UserCount'] = $usercount;
        $departmentcount = Department::count();
        $data['DepartmentCount'] = $departmentcount;
        $badgecount = DepartmentBadge::count();
        $data['BadgeCount'] = $badgecount;
        return view('home',$data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
   public function department()
    {
        return view('department_managenment.deprtment');
    }
   public function badge()
    {
        return view('department_managenment.badge');
    }
}

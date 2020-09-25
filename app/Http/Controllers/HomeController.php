<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;

use App\Admin;
use App\GuestUser;
use App\Department;
use App\DepartmentBadge;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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
        $guestcount = GuestUser::count();
        $data['GuestCount'] = $guestcount;
        $postCount  = Post::count();
        $data['postCount'] = $postCount;
        return view('home', $data);
    }
    public function change_password(Request $request)
    {
        return view('change-password');
    }
    public function change_password_save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => ['required', new MatchOldPassword],
            'password' => ['required', 'min:6'],
            'confirm_password' => ['same:password', 'min:6'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $updatePassword = Admin::where('email', auth()->user()->email)->update(['password' => Hash::make($request->password)]);
        if ($updatePassword) {
            return redirect('change-password')->with('message', 'Your password has been changed succesfully.');
        }
    }
}

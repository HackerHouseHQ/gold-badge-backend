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
    public function userCount(Request $request)
    {
        $year = date("Y");
        $state_id = $request->state_id;
        $country_id = $request->country_id;
        $city_id  = $request->city_id;
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $query = User::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i);
            if (!empty($fromdate) &&  !empty($todate)) {
                $query->Where(function ($q) use ($fromdate, $todate) {

                    $q->wheredate('created_at', '>=', date("Y-m-d", strtotime($fromdate)));
                    $q->wheredate('created_at', '<=', date("Y-m-d", strtotime($todate)));
                });
            }
            if (!empty($country_id)) {
                $query->Where(function ($q) use ($country_id) {
                    $q->where('country_id', $country_id);
                });
            }
            if (!empty($state_id)) {
                $query->Where(function ($q) use ($state_id) {
                    $q->where('state_id', $state_id);
                });
            }
            if (!empty($city_id)) {
                $query->Where(function ($q) use ($city_id) {
                    $q->where('city_id', $city_id);
                });
            }
            $query = $query->count();
            array_push($data, $query);
        }


        return $data;
    }
}

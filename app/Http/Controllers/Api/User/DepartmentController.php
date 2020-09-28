<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserDepartmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function saveDpartmentRequest(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'department_name' => 'required|string'
            ]
        );
        /**
         * Check input parameter validation
         */


        if ($validator->fails()) {
            return res_validation_error($validator); //Sending Validation Error Message
        }

        $insertArray = [
            'user_id' => Auth::user()->id,
            'country_id' => Auth::user()->country_id,
            'state_id' => Auth::user()->state_id,
            'city_id' => Auth::user()->city_id,
            'department_name' => $request->department_name,
            'created_at' => CURRENT_DATE,
            'updated_at' => CURRENT_DATE
        ];
        $saveRequest =  UserDepartmentRequest::insert($insertArray);
        return res_success('Request saved successfully.');
    }
}

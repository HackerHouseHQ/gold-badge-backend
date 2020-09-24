<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOtpLogin extends Model
{
    //
    protected $fillable = ['email', 'otp'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class Admin extends Model
class Admin extends Authenticatable
{
    use Notifiable;
    protected $table = 'admins';
    
    protected $fillable = ['first_name','last_name','email','password'];
}




   

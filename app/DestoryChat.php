<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestoryChat extends Model
{
    //
    protected $fillable = ['destory_time', 'sender_id', 'receiver_id', 'room_id'];
}

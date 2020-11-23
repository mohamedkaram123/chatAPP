<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";

    protected $fillable = [
        'from_user', 'to_user', 'content','record','clear_chat_user1','clear_chat_user2','files'
    ];

    public function user()
    {
        return $this->belongsTo(\User::class);
    }
    public function fromUser()
    {
        return $this->belongsTo('App\User', 'from_user');
    }

    // public function toUser()
    // {
    //     return $this->belongsTo('App\User', 'to_user');
    // }
}

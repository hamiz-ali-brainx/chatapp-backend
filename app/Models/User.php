<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $fillable = ['name', 'email', 'password'];
    public $timestamps = true;

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function friendsTo()
    {
        return $this->belongsToMany(User::class, 'user_friends', 'user_id', 'friends_id')->withPivot('status');
    }
    public function friendsFrom(){
        return $this->belongsToMany(User::class, 'user_friends',  'friends_id','user_id' )->withPivot('user_id', 'friends_id', 'status');
    }
    public function messagesTo(){
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }
    public function messagesFrom(){
        return $this->hasMany(Message::class, 'receiver_id', 'id');
    }
    public function userGroups(){
        return $this->belongsToMany(Group::class, 'user_groups', 'user_id', 'groups_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFriend extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['user_id', 'friends_id', 'status'];


}

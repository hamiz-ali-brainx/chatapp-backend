<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'status'];
    public $timestamps = true;
    protected $casts = [
        'created_at' => 'datetime',
    ];


    public function groupMessages()
    {

        return $this->hasMany(Message::class, 'group_id', 'id');

    }
    public function groupUsers(){
        return $this->belongsToMany(User::class, 'user_groups', 'group_id', 'user_id');
    }
}

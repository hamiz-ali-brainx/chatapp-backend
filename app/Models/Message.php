<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['body', 'sender_id', 'receiver_id', 'group_id'];
    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function messagesTo(){
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
    public function messagesFrom(){
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
    public function groupMessage(){
        return $this->belongsto(Group::class, 'group_id', 'id');
    }

}

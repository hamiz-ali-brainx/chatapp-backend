<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PasswordReset extends Model{

    use HasFactory;
    public $table = "password_resets";
    public $timestamps = false;

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = ['email', 'token'];
}

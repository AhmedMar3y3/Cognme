<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;
    public $timestamps = false;  

    protected $table = 'password_reset_tokens'; 

    protected $fillable = ['email', 'token', 'created_at'];
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';

}

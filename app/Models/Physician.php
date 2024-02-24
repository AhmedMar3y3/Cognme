<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Physician extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'user_id', 'name', 'email', 'specialization', 'contact'
    ];
    public function user(){
        return $this->hasMany(User::class);
       // return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContacts extends Model
{
    use HasFactory;
    // protected $fillable =
    // [
    //     'user_id','image', 'name', 'contact'
    // ];
    // public function user()
    // { 
    //     return $this->belongsTo(User::class);
    // }
    protected $fillable = [
        'user_id',
        'image',
        'name',
        'contact',
        'relation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

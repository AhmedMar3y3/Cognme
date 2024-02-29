<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Physician extends Model
{
    use HasFactory;
    // protected $fillable =
    // [
    //     'user_id', 'name', 'email','address', 'specialization', 'contact'
    // ];
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'specialization',
        'contact',
        'prescription',
    ];
    public function user()
    { 
        return $this->belongsTo(User::class);
    }
    
}

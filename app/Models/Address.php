<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'address_type',
        'address_info',
    ];
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function doctor()
    {
        return $this->hasOne(Physician::class);
    }
   
}

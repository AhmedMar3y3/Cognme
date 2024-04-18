<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'user_id',
        'name', 'age',
        'medical_history',
        'address',
        'photo_paths'
    ];
    public function user()
    { 
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'photo_paths' => 'array',
    ];
}

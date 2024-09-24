<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => 'boolean', // Automatically casts 0/1 to boolean values
    ];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

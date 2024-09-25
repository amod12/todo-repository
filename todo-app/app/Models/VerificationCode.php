<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    protected $table = 'verification_codes'; // Specify the table name

    protected $fillable = [
        'email',
        'user_id',
        'code',
    ];

    // Define any relationships if needed, for example:
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


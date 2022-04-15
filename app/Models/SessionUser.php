<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'token', 'refresh_token', 'token_expreid','user_id',
    ];
}
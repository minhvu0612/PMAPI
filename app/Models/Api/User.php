<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table="users";
    protected $fillable = [
        'name',
        'email',
        'password',
        "role",
        'created_at',
        'updated_at',
    ];
}

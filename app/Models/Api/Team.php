<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $table = "teams";
    protected $fillable = [
        'teamcode',
        'name',
        'carry',
        'created_at',
        'updated_at',
    ];
}

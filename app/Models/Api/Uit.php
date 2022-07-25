<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uit extends Model
{
    use HasFactory;
    protected $table="userinteams";
    protected $fillable = [
        'team_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $with = ['user', 'team'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}

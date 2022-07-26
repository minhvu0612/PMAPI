<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;
    protected $table="ranks";
    protected $fillable = [
        'teamcode',
        'vote',
        'created_at',
        'updated_at',
    ];

    protected $with = ['team'];
    
    public function team()
    {
        return $this->belongsTo(Team::class, 'teamcode', 'code');
    }
}

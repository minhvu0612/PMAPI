<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = "projects";
    protected $fillable = [
        'name',
        'startline',
        'deadline',
        'content',
        'teamcode',
        'time',
        'state',
        'created_at',
        'updated_at',
    ];

    protected $with = ['team'];

    public function team()
    {
        return $this->belongsTo(Team::class, 'teamcode', 'code');
    }
}

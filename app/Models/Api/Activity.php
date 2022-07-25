<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    // Đặt tên bảng
    protected $table = "activities";
    // Các thuộc tính
    protected $fillable = [
        'user_id',
        'team_id',
        'project_id',
        'state',
        'created_at',
        'updated_at',
    ];

    // Xử lý khóa ngoại
    protected $with = ['user', 'team', 'project'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}

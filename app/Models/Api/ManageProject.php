<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageProject extends Model
{
    use HasFactory;
    // Đặt tên bảng
    protected $table = "manageproject";
    // Các thuộc tính
    protected $fillable = [
        'user_id',
        'projectcode',
        'state',
        'created_at',
        'updated_at',
    ];

    // Xử lý khóa ngoại
    protected $with = ['user', 'project'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'projectcode', 'code');
    }
}

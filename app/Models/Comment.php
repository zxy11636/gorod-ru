<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'parent_id',
        'content',
        'likes_count',
        'dislikes_count',
        'edited_at',
    ];

    protected $casts = [
        'edited_at' => 'datetime',
    ];

    // Связи
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user');
    }

    // Проверка: может ли пользователь редактировать
    public function canEdit($userId): bool
    {
        return $this->user_id === $userId || auth()->user()?->role === 'admin';
    }
}
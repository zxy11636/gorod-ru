<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'city',
        'district',
        'goal_amount',
        'current_amount',
        'status',
        'deadline',
        'image',
        'images',
        'lat',
        'lng',
    ];

    protected $casts = [
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'images' => 'array', // JSON поле
        'deadline' => 'date',
    ];

    // Связь с автором
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Связь с пожертвованиями
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    // Процент сбора
    public function getProgressPercentAttribute()
    {
        if ($this->goal_amount <= 0) return 0;
        return min(100, round(($this->current_amount / $this->goal_amount) * 100));
    }

    // Форматирование сумм
    public function getFormattedGoalAttribute()
    {
        return number_format($this->goal_amount, 0, '.', ' ') . ' ₽';
    }

    public function getFormattedCurrentAttribute()
    {
        return number_format($this->current_amount, 0, '.', ' ') . ' ₽';
    }

    // Цвет бейджа по категории
    public function getBadgeColorAttribute(): string
{
    $colors = [
        'parks'     => 'green',   // Парки и скверы
        'roads'     => 'orange',  // Дороги и тротуары
        'buildings' => 'gray',    // Здания и фасады
        'sport'     => 'blue',    // Спортивные объекты
        'culture'   => 'purple',  // Культурные объекты
        'ecology'   => 'green',   // Экология
        'health'    => 'red',     // Здравоохранение
    ];
    
    return $colors[$this->category] ?? 'blue';
}
    public function getCategoryNameAttribute(): string
{
    $category = \App\Models\Category::where('slug', $this->category)->first();
    return $category ? $category->name : $this->category;
}

/**
 * Аксессор: возвращает цвет бейджа по slug категории
 */

    
    
}
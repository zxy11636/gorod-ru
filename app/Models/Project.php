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
        'lng'
    ];

    protected $casts = [
        'images' => 'array',
        'deadline' => 'date',
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function getProgressPercentage()
    {
        if ($this->goal_amount > 0) {
            return min(100, round(($this->current_amount / $this->goal_amount) * 100));
        }
        return 0;
    }
}
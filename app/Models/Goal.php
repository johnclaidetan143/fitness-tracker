<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['user_id', 'daily_steps', 'target_weight', 'workout_days_per_week', 'daily_water_glasses', 'daily_workout_minutes'];

    public function user() { return $this->belongsTo(User::class); }
}

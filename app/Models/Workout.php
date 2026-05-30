<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = ['user_id', 'name', 'type', 'duration_minutes', 'calories_burned', 'steps', 'notes', 'workout_date'];

    protected $casts = ['workout_date' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function sets() { return $this->hasMany(WorkoutSet::class); }
}

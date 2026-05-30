<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutSet extends Model
{
    protected $fillable = ['workout_id', 'exercise_name', 'sets', 'reps', 'weight_kg', 'duration_seconds'];
    public function workout() { return $this->belongsTo(Workout::class); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutTemplate extends Model
{
    protected $fillable = ['user_id', 'name', 'type', 'exercises', 'estimated_minutes'];
    protected $casts = ['exercises' => 'array'];
    public function user() { return $this->belongsTo(User::class); }
}

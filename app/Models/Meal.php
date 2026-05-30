<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['user_id', 'name', 'meal_type', 'calories', 'protein', 'carbs', 'fat', 'meal_date'];
    protected $casts = ['meal_date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
}

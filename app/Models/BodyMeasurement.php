<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyMeasurement extends Model
{
    protected $fillable = ['user_id', 'waist', 'chest', 'arms', 'legs', 'hips', 'neck', 'measured_date'];
    protected $casts = ['measured_date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
}

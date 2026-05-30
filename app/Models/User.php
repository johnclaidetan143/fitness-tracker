<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'avatar', 'weight', 'height', 'age', 'is_admin'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'is_admin' => 'boolean'];
    }

    public function goals() { return $this->hasOne(Goal::class); }
    public function workouts() { return $this->hasMany(Workout::class); }
    public function waterLogs() { return $this->hasMany(WaterLog::class); }
    public function streak() { return $this->hasOne(Streak::class); }
    public function achievements() { return $this->belongsToMany(Achievement::class, 'user_achievements')->withPivot('earned_at'); }
    public function meals() { return $this->hasMany(Meal::class); }
    public function personalRecords() { return $this->hasMany(PersonalRecord::class); }
    public function bmiLogs() { return $this->hasMany(BmiLog::class); }
    public function bodyMeasurements() { return $this->hasMany(BodyMeasurement::class); }
    public function sleepLogs() { return $this->hasMany(SleepLog::class); }
    public function workoutTemplates() { return $this->hasMany(WorkoutTemplate::class); }
}

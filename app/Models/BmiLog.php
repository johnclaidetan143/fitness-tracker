<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BmiLog extends Model
{
    protected $fillable = ['user_id', 'weight', 'height', 'bmi', 'log_date'];
    protected $casts = ['log_date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
}

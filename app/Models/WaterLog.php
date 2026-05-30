<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterLog extends Model
{
    protected $fillable = ['user_id', 'glasses', 'ml', 'log_date'];

    protected $casts = ['log_date' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
}

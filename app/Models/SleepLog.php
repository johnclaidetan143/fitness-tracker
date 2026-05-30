<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SleepLog extends Model
{
    protected $fillable = ['user_id', 'hours', 'quality', 'sleep_date'];
    protected $casts = ['sleep_date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
}

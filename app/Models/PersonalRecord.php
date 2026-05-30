<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalRecord extends Model
{
    protected $fillable = ['user_id', 'type', 'value', 'record_date'];
    protected $casts = ['record_date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
}

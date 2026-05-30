<?php

namespace App\Http\Controllers;

use App\Models\PersonalRecord;
use App\Models\Workout;
use App\Models\WaterLog;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $records = PersonalRecord::where('user_id', $user->id)->get()->keyBy('type');

        $labels = [
            'most_steps'      => ['label' => 'Most Steps in a Day',     'icon' => 'fa-shoe-prints',  'color' => 'indigo', 'unit' => 'steps'],
            'most_calories'   => ['label' => 'Most Calories Burned',     'icon' => 'fa-fire',         'color' => 'orange', 'unit' => 'kcal'],
            'longest_workout' => ['label' => 'Longest Workout',          'icon' => 'fa-clock',        'color' => 'green',  'unit' => 'min'],
            'most_water'      => ['label' => 'Most Water in a Day',      'icon' => 'fa-droplet',      'color' => 'cyan',   'unit' => 'glasses'],
        ];

        return view('records.index', compact('records', 'labels'));
    }
}

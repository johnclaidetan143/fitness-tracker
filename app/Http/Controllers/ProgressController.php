<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\WaterLog;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $goals = $user->goals ?? $user->goals()->create([]);
        $today = now()->toDateString();

        $todaySteps = Workout::where('user_id', $user->id)->whereDate('workout_date', $today)->sum('steps');
        $todayCalories = Workout::where('user_id', $user->id)->whereDate('workout_date', $today)->sum('calories_burned');
        $todayMinutes = Workout::where('user_id', $user->id)->whereDate('workout_date', $today)->sum('duration_minutes');
        $todayWater = WaterLog::where('user_id', $user->id)->whereDate('log_date', $today)->sum('glasses');

        $weekWorkoutDays = Workout::where('user_id', $user->id)
            ->whereBetween('workout_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->distinct('workout_date')->count('workout_date');

        return view('progress.index', compact('goals', 'todaySteps', 'todayCalories', 'todayMinutes', 'todayWater', 'weekWorkoutDays', 'user'));
    }
}

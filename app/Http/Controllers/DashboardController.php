<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\WaterLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $goals = $user->goals ?? $user->goals()->create([]);
        $today = now()->toDateString();

        $todayWorkouts = Workout::where('user_id', $user->id)->whereDate('workout_date', $today)->get();
        $todaySteps    = $todayWorkouts->sum('steps');
        $todayCalories = $todayWorkouts->sum('calories_burned');
        $todayMinutes  = $todayWorkouts->sum('duration_minutes');
        $todayWater    = WaterLog::where('user_id', $user->id)->whereDate('log_date', $today)->sum('glasses');

        $streak             = $user->streak;
        $totalWorkouts      = $user->workouts()->count();
        $recentAchievements = $user->achievements()->withPivot('earned_at')->orderByDesc('user_achievements.earned_at')->take(3)->get();

        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $weeklyData[] = [
                'date'     => now()->subDays($i)->format('D'),
                'calories' => Workout::where('user_id', $user->id)->whereDate('workout_date', $date)->sum('calories_burned'),
                'steps'    => Workout::where('user_id', $user->id)->whereDate('workout_date', $date)->sum('steps'),
                'minutes'  => Workout::where('user_id', $user->id)->whereDate('workout_date', $date)->sum('duration_minutes'),
            ];
        }

        return view('dashboard', compact('user', 'goals', 'todaySteps', 'todayCalories', 'todayMinutes', 'todayWater', 'weeklyData', 'todayWorkouts', 'streak', 'totalWorkouts', 'recentAchievements'));
    }
}

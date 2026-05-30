<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\WaterLog;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Last 4 weeks data
        $weeks = [];
        for ($w = 3; $w >= 0; $w--) {
            $start = now()->subWeeks($w)->startOfWeek();
            $end   = now()->subWeeks($w)->endOfWeek();
            $weeks[] = [
                'label'    => $start->format('M d') . ' - ' . $end->format('M d'),
                'steps'    => Workout::where('user_id', $user->id)->whereBetween('workout_date', [$start, $end])->sum('steps'),
                'calories' => Workout::where('user_id', $user->id)->whereBetween('workout_date', [$start, $end])->sum('calories_burned'),
                'minutes'  => Workout::where('user_id', $user->id)->whereBetween('workout_date', [$start, $end])->sum('duration_minutes'),
                'workouts' => Workout::where('user_id', $user->id)->whereBetween('workout_date', [$start, $end])->count(),
            ];
        }

        // Last 6 months
        $months = [];
        for ($m = 5; $m >= 0; $m--) {
            $date  = now()->subMonths($m);
            $months[] = [
                'label'    => $date->format('M Y'),
                'steps'    => Workout::where('user_id', $user->id)->whereYear('workout_date', $date->year)->whereMonth('workout_date', $date->month)->sum('steps'),
                'calories' => Workout::where('user_id', $user->id)->whereYear('workout_date', $date->year)->whereMonth('workout_date', $date->month)->sum('calories_burned'),
                'workouts' => Workout::where('user_id', $user->id)->whereYear('workout_date', $date->year)->whereMonth('workout_date', $date->month)->count(),
            ];
        }

        // This month summary
        $thisMonth = now();
        $summary = [
            'total_workouts'  => Workout::where('user_id', $user->id)->whereYear('workout_date', $thisMonth->year)->whereMonth('workout_date', $thisMonth->month)->count(),
            'total_steps'     => Workout::where('user_id', $user->id)->whereYear('workout_date', $thisMonth->year)->whereMonth('workout_date', $thisMonth->month)->sum('steps'),
            'total_calories'  => Workout::where('user_id', $user->id)->whereYear('workout_date', $thisMonth->year)->whereMonth('workout_date', $thisMonth->month)->sum('calories_burned'),
            'total_minutes'   => Workout::where('user_id', $user->id)->whereYear('workout_date', $thisMonth->year)->whereMonth('workout_date', $thisMonth->month)->sum('duration_minutes'),
            'total_water'     => WaterLog::where('user_id', $user->id)->whereYear('log_date', $thisMonth->year)->whereMonth('log_date', $thisMonth->month)->sum('glasses'),
            'total_meals_cal' => Meal::where('user_id', $user->id)->whereYear('meal_date', $thisMonth->year)->whereMonth('meal_date', $thisMonth->month)->sum('calories'),
        ];

        return view('reports.index', compact('weeks', 'months', 'summary'));
    }
}

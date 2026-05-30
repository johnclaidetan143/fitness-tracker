<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Achievement;
use App\Models\SleepLog;
use App\Models\User;
use App\Models\Workout;
use App\Models\WaterLog;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'admins' => User::where('is_admin', true)->count(),
            'workouts' => Workout::count(),
            'meals' => Meal::count(),
            'waterLogs' => WaterLog::count(),
        ];

        $recentUsers = User::latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function workouts()
    {
        $workouts = Workout::with('user')->latest('workout_date')->paginate(10);

        return view('admin.workouts', compact('workouts'));
    }

    public function meals()
    {
        $meals = Meal::with('user')->latest('meal_date')->paginate(10);

        return view('admin.meals', compact('meals'));
    }

    public function waterLogs()
    {
        $waterLogs = WaterLog::with('user')->latest('log_date')->paginate(10);

        return view('admin.water-logs', compact('waterLogs'));
    }

    public function achievements()
    {
        $achievements = Achievement::withCount('users')->orderBy('name')->paginate(10);

        return view('admin.achievements', compact('achievements'));
    }

    public function reports()
    {
        $stats = [
            'users' => User::count(),
            'workouts' => Workout::count(),
            'meals' => Meal::count(),
            'waterLogs' => WaterLog::count(),
            'sleepLogs' => SleepLog::count(),
            'achievements' => Achievement::count(),
            'totalCaloriesBurned' => Workout::sum('calories_burned'),
            'totalWorkoutMinutes' => Workout::sum('duration_minutes'),
            'totalMealCalories' => Meal::sum('calories'),
            'totalWaterMl' => WaterLog::sum('ml'),
        ];

        return view('admin.reports', compact('stats'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FitnessService;

class MealController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->toDateString();
        $todayMeals = Meal::where('user_id', $user->id)->whereDate('meal_date', $today)->orderBy('meal_type')->get();
        $todayCalories = $todayMeals->sum('calories');
        $todayProtein  = $todayMeals->sum('protein');
        $todayCarbs    = $todayMeals->sum('carbs');
        $todayFat      = $todayMeals->sum('fat');
        $recentMeals   = Meal::where('user_id', $user->id)->orderByDesc('meal_date')->take(20)->get();
        $calorieGoal   = 2000;
        return view('meals.index', compact('todayMeals', 'todayCalories', 'todayProtein', 'todayCarbs', 'todayFat', 'recentMeals', 'calorieGoal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'calories'  => 'required|integer|min:0',
            'protein'   => 'nullable|numeric|min:0',
            'carbs'     => 'nullable|numeric|min:0',
            'fat'       => 'nullable|numeric|min:0',
            'meal_date' => 'required|date',
        ]);
        $data['user_id'] = Auth::id();
        $data['protein'] = $data['protein'] ?? 0;
        $data['carbs']   = $data['carbs'] ?? 0;
        $data['fat']     = $data['fat'] ?? 0;
        Meal::create($data);
        FitnessService::checkAchievements(Auth::user());
        return back()->with('success', 'Meal logged!');
    }

    public function destroy(Meal $meal)
    {
        abort_if($meal->user_id !== Auth::id(), 403);
        $meal->delete();
        return back()->with('success', 'Meal removed.');
    }
}

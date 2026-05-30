<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function edit()
    {
        $goals = Auth::user()->goals ?? Auth::user()->goals()->create([]);
        return view('goals.edit', compact('goals'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'daily_steps' => 'required|integer|min:100',
            'target_weight' => 'nullable|numeric|min:20|max:300',
            'workout_days_per_week' => 'required|integer|min:1|max:7',
            'daily_water_glasses' => 'required|integer|min:1|max:20',
            'daily_workout_minutes' => 'required|integer|min:5',
        ]);

        Auth::user()->goals()->updateOrCreate(['user_id' => Auth::id()], $data);
        return redirect()->route('goals.edit')->with('success', 'Goals updated!');
    }
}

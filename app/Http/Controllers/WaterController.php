<?php

namespace App\Http\Controllers;

use App\Models\WaterLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $goals = $user->goals;
        $today = now()->toDateString();
        $todayGlasses = WaterLog::where('user_id', $user->id)->whereDate('log_date', $today)->sum('glasses');
        $logs = WaterLog::where('user_id', $user->id)->orderByDesc('log_date')->take(7)->get();
        return view('water.index', compact('todayGlasses', 'goals', 'logs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['glasses' => 'required|integer|min:1|max:20']);
        WaterLog::create([
            'user_id' => Auth::id(),
            'glasses' => $data['glasses'],
            'ml' => $data['glasses'] * 250,
            'log_date' => now()->toDateString(),
        ]);
        return back()->with('success', 'Water intake logged!');
    }

    public function destroy(WaterLog $waterLog)
    {
        abort_if($waterLog->user_id !== Auth::id(), 403);
        $waterLog->delete();
        return back()->with('success', 'Entry removed.');
    }
}

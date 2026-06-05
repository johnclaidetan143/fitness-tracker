<?php

namespace App\Http\Controllers;

use App\Models\SleepLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\FitnessService;

class SleepController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $logs = SleepLog::where('user_id', $user->id)->orderByDesc('sleep_date')->take(14)->get();
        $avgHours = $logs->avg('hours') ?? 0;
        $todayLog = SleepLog::where('user_id', $user->id)->whereDate('sleep_date', now()->toDateString())->first();

        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $log  = SleepLog::where('user_id', $user->id)->whereDate('sleep_date', $date)->first();
            $weeklyData[] = [
                'date'  => now()->subDays($i)->format('D'),
                'hours' => $log ? $log->hours : 0,
            ];
        }

        return view('sleep.index', compact('logs', 'avgHours', 'todayLog', 'weeklyData'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hours'      => 'required|numeric|min:0.5|max:24',
            'quality'    => 'required|in:poor,fair,good,excellent',
            'sleep_date' => 'required|date',
        ]);
        $data['user_id'] = Auth::id();

        SleepLog::updateOrCreate(
            ['user_id' => Auth::id(), 'sleep_date' => $data['sleep_date']],
            $data
        );
        FitnessService::checkAchievements(Auth::user());
        return back()->with('success', 'Sleep logged!');
    }

    public function destroy(SleepLog $sleepLog)
    {
        abort_if($sleepLog->user_id !== Auth::id(), 403);
        $sleepLog->delete();
        return back()->with('success', 'Entry deleted.');
    }
}

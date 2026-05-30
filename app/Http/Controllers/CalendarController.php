<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $year  = request('year', now()->year);
        $month = request('month', now()->month);

        $workouts = Workout::where('user_id', $user->id)
            ->whereYear('workout_date', $year)
            ->whereMonth('workout_date', $month)
            ->get()
            ->groupBy(fn($w) => $w->workout_date->format('Y-m-d'));

        $daysInMonth = now()->setYear($year)->setMonth($month)->daysInMonth;
        $firstDayOfWeek = now()->setYear($year)->setMonth($month)->startOfMonth()->dayOfWeek;

        $prevMonth = now()->setYear($year)->setMonth($month)->subMonth();
        $nextMonth = now()->setYear($year)->setMonth($month)->addMonth();

        return view('calendar.index', compact('workouts', 'daysInMonth', 'firstDayOfWeek', 'year', 'month', 'prevMonth', 'nextMonth'));
    }
}

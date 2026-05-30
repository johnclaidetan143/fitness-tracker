@extends('layouts.app')
@section('title', 'Workout Calendar')
@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">📅 Workout Calendar</h1>
    <div class="flex items-center gap-3">
        <a href="{{ route('calendar.index', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
           class="w-9 h-9 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
            <i class="fa-solid fa-chevron-left text-sm"></i>
        </a>
        <span class="font-bold text-slate-700 min-w-32 text-center">
            {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}
        </span>
        <a href="{{ route('calendar.index', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
           class="w-9 h-9 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
            <i class="fa-solid fa-chevron-right text-sm"></i>
        </a>
    </div>
</div>

<div class="card">
    {{-- Day headers --}}
    <div class="grid grid-cols-7 mb-2">
        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
        <div class="text-center text-xs font-semibold text-slate-400 py-2">{{ $day }}</div>
        @endforeach
    </div>

    {{-- Calendar grid --}}
    <div class="grid grid-cols-7 gap-1">
        {{-- Empty cells before first day --}}
        @for($i = 0; $i < $firstDayOfWeek; $i++)
        <div class="h-20 rounded-xl"></div>
        @endfor

        {{-- Days --}}
        @for($day = 1; $day <= $daysInMonth; $day++)
        @php
            $dateKey = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
            $dayWorkouts = $workouts[$dateKey] ?? collect();
            $isToday = $dateKey === now()->toDateString();
        @endphp
        <div class="h-20 rounded-xl p-1.5 {{ $isToday ? 'bg-indigo-50 ring-2 ring-indigo-400' : 'bg-slate-50 hover:bg-slate-100' }} transition-all">
            <p class="text-xs font-bold {{ $isToday ? 'text-indigo-600' : 'text-slate-600' }} mb-1">{{ $day }}</p>
            @if($dayWorkouts->count() > 0)
                <div class="w-6 h-6 bg-indigo-500 rounded-lg flex items-center justify-center mx-auto">
                    <i class="fa-solid fa-dumbbell text-white text-xs"></i>
                </div>
                <p class="text-center text-xs text-indigo-600 font-medium mt-0.5">{{ $dayWorkouts->count() }}</p>
            @endif
        </div>
        @endfor
    </div>

    {{-- Legend --}}
    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-slate-100 text-xs text-slate-500">
        <div class="flex items-center gap-1.5">
            <div class="w-5 h-5 bg-indigo-500 rounded flex items-center justify-center"><i class="fa-solid fa-dumbbell text-white text-xs"></i></div>
            <span>Workout day</span>
        </div>
        <div class="flex items-center gap-1.5">
            <div class="w-5 h-5 bg-indigo-50 ring-2 ring-indigo-400 rounded"></div>
            <span>Today</span>
        </div>
        <span class="ml-auto">Total active days: <strong class="text-slate-700">{{ $workouts->count() }}</strong></span>
    </div>
</div>
@endsection

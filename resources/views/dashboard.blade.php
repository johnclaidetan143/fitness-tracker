@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Good afternoon, {{ Auth::user()->name }}!</h1>
    <p class="text-slate-500 text-sm mt-1">{{ now()->format('l, F j, Y') }}</p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
    @php
        $cards = [
            ['label' => 'Steps Today',     'value' => number_format($todaySteps),    'goal' => number_format($goals->daily_steps),           'pct' => min(100, $goals->daily_steps > 0 ? round($todaySteps / $goals->daily_steps * 100) : 0),               'icon' => 'fa-shoe-prints',  'color' => 'indigo', 'unit' => 'steps'],
            ['label' => 'Calories Burned', 'value' => number_format($todayCalories), 'goal' => '500',                                         'pct' => min(100, round($todayCalories / 500 * 100)),                                                           'icon' => 'fa-fire',         'color' => 'orange', 'unit' => 'kcal'],
            ['label' => 'Workout Time',    'value' => $todayMinutes,                 'goal' => $goals->daily_workout_minutes,                 'pct' => min(100, $goals->daily_workout_minutes > 0 ? round($todayMinutes / $goals->daily_workout_minutes * 100) : 0), 'icon' => 'fa-clock',    'color' => 'green',  'unit' => 'min'],
            ['label' => 'Water Intake',    'value' => $todayWater,                   'goal' => $goals->daily_water_glasses,                   'pct' => min(100, $goals->daily_water_glasses > 0 ? round($todayWater / $goals->daily_water_glasses * 100) : 0),   'icon' => 'fa-droplet',      'color' => 'cyan',   'unit' => 'glasses'],
        ];
        $colorMap = [
            'indigo' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'bar' => 'bg-indigo-500'],
            'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'bar' => 'bg-orange-500'],
            'green'  => ['bg' => 'bg-green-100',  'text' => 'text-green-600',  'bar' => 'bg-green-500'],
            'cyan'   => ['bg' => 'bg-cyan-100',   'text' => 'text-cyan-600',   'bar' => 'bg-cyan-500'],
        ];
    @endphp

    @foreach($cards as $card)
    @php $c = $colorMap[$card['color']]; @endphp
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <div class="{{ $c['bg'] }} {{ $c['text'] }} w-11 h-11 rounded-xl flex items-center justify-center">
                <i class="fa-solid {{ $card['icon'] }} text-lg"></i>
            </div>
            <span class="text-xs font-semibold {{ $card['pct'] >= 100 ? 'text-green-600 bg-green-100' : 'text-slate-500 bg-slate-100' }} px-2 py-1 rounded-full">
                {{ $card['pct'] }}%
            </span>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $card['value'] }} <span class="text-sm font-normal text-slate-400">{{ $card['unit'] }}</span></p>
        <p class="text-sm text-slate-500 mt-1">{{ $card['label'] }}</p>
        <div class="mt-3 bg-slate-100 rounded-full h-2">
            <div class="{{ $c['bar'] }} h-2 rounded-full transition-all duration-700" style="width: {{ $card['pct'] }}%"></div>
        </div>
        <p class="text-xs text-slate-400 mt-1">Goal: {{ $card['goal'] }} {{ $card['unit'] }}</p>
    </div>
    @endforeach
</div>

{{-- Streak + Achievements row --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">
    {{-- Streak --}}
    <div class="card text-center">
        <p class="text-slate-500 text-sm font-medium mb-2">Current Streak</p>
        <div class="text-5xl mb-1">🔥</div>
        <p class="text-4xl font-bold text-orange-500">{{ $streak->current_streak ?? 0 }}</p>
        <p class="text-slate-400 text-sm">days in a row</p>
        <div class="mt-3 pt-3 border-t border-slate-100 flex justify-center gap-6 text-sm">
            <div>
                <p class="font-bold text-slate-700">{{ $streak->longest_streak ?? 0 }}</p>
                <p class="text-slate-400 text-xs">Best Streak</p>
            </div>
            <div>
                <p class="font-bold text-slate-700">{{ $totalWorkouts }}</p>
                <p class="text-slate-400 text-xs">Total Workouts</p>
            </div>
        </div>
    </div>

    {{-- Recent Achievements --}}
    <div class="card xl:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-slate-800">Recent Achievements</h2>
            <a href="{{ route('achievements.index') }}" class="text-indigo-600 text-sm hover:underline">View all</a>
        </div>
        @forelse($recentAchievements as $a)
        <div class="flex items-center gap-3 py-2 border-b border-slate-100 last:border-0">
            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid {{ $a->icon }} text-yellow-500"></i>
            </div>
            <div>
                <p class="font-medium text-slate-700 text-sm">{{ $a->name }}</p>
                <p class="text-xs text-slate-400">{{ $a->pivot->earned_at ? \Carbon\Carbon::parse($a->pivot->earned_at)->diffForHumans() : '' }}</p>
            </div>
        </div>
        @empty
        <div class="text-center py-6 text-slate-400">
            <i class="fa-solid fa-medal text-3xl mb-2 block"></i>
            <p class="text-sm">Log a workout to earn achievements!</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Chart + Today's Workouts --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
    <div class="card xl:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-slate-800">Weekly Activity</h2>
            <span class="text-xs text-slate-400">Last 7 days</span>
        </div>
        <canvas id="weeklyChart" height="100"></canvas>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-slate-800">Today's Workouts</h2>
            <a href="{{ route('workouts.create') }}" class="text-indigo-600 text-sm font-medium hover:underline">+ Add</a>
        </div>
        @forelse($todayWorkouts as $w)
        <div class="flex items-center gap-3 py-2 border-b border-slate-100 last:border-0">
            <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid {{ $w->type === 'running' ? 'fa-person-running' : ($w->type === 'pushups' ? 'fa-hand-fist' : ($w->type === 'plank' ? 'fa-person' : 'fa-dumbbell')) }} text-indigo-600 text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-700 truncate">{{ $w->name }}</p>
                <p class="text-xs text-slate-400">{{ $w->duration_minutes }} min · {{ $w->calories_burned }} kcal</p>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-slate-400">
            <i class="fa-solid fa-dumbbell text-3xl mb-2 block"></i>
            <p class="text-sm">No workouts today</p>
        </div>
        @endforelse
    </div>
</div>

<script>
const ctx = document.getElementById('weeklyChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($weeklyData, 'date')) !!},
        datasets: [
            { label: 'Calories', data: {!! json_encode(array_column($weeklyData, 'calories')) !!}, backgroundColor: 'rgba(99,102,241,0.7)', borderRadius: 6 },
            { label: 'Steps',    data: {!! json_encode(array_column($weeklyData, 'steps')) !!},    backgroundColor: 'rgba(34,211,238,0.7)', borderRadius: 6, yAxisID: 'y1' }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y:  { beginAtZero: true, title: { display: true, text: 'Calories' } },
            y1: { beginAtZero: true, position: 'right', title: { display: true, text: 'Steps' }, grid: { drawOnChartArea: false } }
        }
    }
});
</script>
@endsection


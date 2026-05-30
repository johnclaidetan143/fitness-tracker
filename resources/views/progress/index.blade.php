@extends('layouts.app')
@section('title', 'Progress')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">📈 Progress Tracking</h1>
    <p class="text-slate-500 text-sm mt-1">Today's progress vs your goals</p>
</div>

@php
$metrics = [
    ['label' => 'Steps', 'current' => $todaySteps, 'goal' => $goals->daily_steps, 'unit' => 'steps', 'icon' => 'fa-shoe-prints', 'color' => 'indigo'],
    ['label' => 'Workout Time', 'current' => $todayMinutes, 'goal' => $goals->daily_workout_minutes, 'unit' => 'min', 'icon' => 'fa-clock', 'color' => 'green'],
    ['label' => 'Water Intake', 'current' => $todayWater, 'goal' => $goals->daily_water_glasses, 'unit' => 'glasses', 'icon' => 'fa-droplet', 'color' => 'cyan'],
    ['label' => 'Workout Days (Week)', 'current' => $weekWorkoutDays, 'goal' => $goals->workout_days_per_week, 'unit' => 'days', 'icon' => 'fa-calendar-check', 'color' => 'purple'],
];
$colorMap = [
    'indigo' => ['bar' => 'bg-indigo-500', 'text' => 'text-indigo-600', 'bg' => 'bg-indigo-100'],
    'green' => ['bar' => 'bg-green-500', 'text' => 'text-green-600', 'bg' => 'bg-green-100'],
    'cyan' => ['bar' => 'bg-cyan-500', 'text' => 'text-cyan-600', 'bg' => 'bg-cyan-100'],
    'purple' => ['bar' => 'bg-purple-500', 'text' => 'text-purple-600', 'bg' => 'bg-purple-100'],
];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
    @foreach($metrics as $m)
    @php
        $pct = $m['goal'] > 0 ? min(100, round($m['current'] / $m['goal'] * 100)) : 0;
        $c = $colorMap[$m['color']];
    @endphp
    <div class="card">
        <div class="flex items-center gap-3 mb-4">
            <div class="{{ $c['bg'] }} {{ $c['text'] }} w-11 h-11 rounded-xl flex items-center justify-center">
                <i class="fa-solid {{ $m['icon'] }} text-lg"></i>
            </div>
            <div>
                <p class="font-semibold text-slate-800">{{ $m['label'] }}</p>
                <p class="text-sm text-slate-500">{{ number_format($m['current']) }} / {{ number_format($m['goal']) }} {{ $m['unit'] }}</p>
            </div>
            <div class="ml-auto text-right">
                <span class="text-2xl font-bold {{ $c['text'] }}">{{ $pct }}%</span>
                @if($pct >= 100)<span class="block text-xs text-green-600">✓ Goal met!</span>@endif
            </div>
        </div>
        <div class="bg-slate-100 rounded-full h-4 overflow-hidden">
            <div class="{{ $c['bar'] }} h-4 rounded-full transition-all duration-700 flex items-center justify-end pr-2" style="width: {{ max(4, $pct) }}%">
                @if($pct > 15)<span class="text-white text-xs font-bold">{{ $pct }}%</span>@endif
            </div>
        </div>
        <div class="flex justify-between text-xs text-slate-400 mt-1">
            <span>0</span>
            <span>{{ number_format($m['goal']) }} {{ $m['unit'] }}</span>
        </div>
    </div>
    @endforeach
</div>

@if($user->weight && $goals->target_weight)
<div class="card">
    @php
        $weightDiff = $user->weight - $goals->target_weight;
        $weightPct = $weightDiff > 0 ? min(100, round((1 - $weightDiff / $user->weight) * 100)) : 100;
    @endphp
    <div class="flex items-center gap-3 mb-4">
        <div class="bg-pink-100 text-pink-600 w-11 h-11 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-weight-scale text-lg"></i>
        </div>
        <div>
            <p class="font-semibold text-slate-800">Weight Goal</p>
            <p class="text-sm text-slate-500">Current: {{ $user->weight }} kg → Target: {{ $goals->target_weight }} kg</p>
        </div>
        <div class="ml-auto">
            @if($weightDiff > 0)
                <span class="text-orange-600 font-semibold">{{ number_format($weightDiff, 1) }} kg to go</span>
            @else
                <span class="text-green-600 font-semibold">✓ Goal reached!</span>
            @endif
        </div>
    </div>
    <div class="bg-slate-100 rounded-full h-4 overflow-hidden">
        <div class="bg-pink-500 h-4 rounded-full transition-all duration-700" style="width: {{ $weightPct }}%"></div>
    </div>
</div>
@else
<div class="card border-2 border-dashed border-slate-200 text-center py-8 text-slate-400">
    <i class="fa-solid fa-weight-scale text-3xl mb-2 block"></i>
    <p class="text-sm">Set your weight & target in <a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:underline">Profile</a> and <a href="{{ route('goals.edit') }}" class="text-indigo-600 hover:underline">Goals</a> to track weight progress</p>
</div>
@endif
@endsection

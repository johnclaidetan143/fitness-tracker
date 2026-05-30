@extends('layouts.admin')
@section('title', 'Reports')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-sm font-bold uppercase tracking-widest text-indigo-500">Insights</p>
        <h1 class="text-3xl font-extrabold text-slate-900">Reports</h1>
        <p class="mt-1 text-slate-500">Quick totals across the fitness tracking system.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['Users', $stats['users'], 'fa-users', 'bg-indigo-100 text-indigo-600'],
            ['Workouts', $stats['workouts'], 'fa-dumbbell', 'bg-emerald-100 text-emerald-600'],
            ['Meals', $stats['meals'], 'fa-utensils', 'bg-orange-100 text-orange-600'],
            ['Water Logs', $stats['waterLogs'], 'fa-droplet', 'bg-cyan-100 text-cyan-600'],
            ['Sleep Logs', $stats['sleepLogs'], 'fa-moon', 'bg-violet-100 text-violet-600'],
            ['Achievements', $stats['achievements'], 'fa-medal', 'bg-amber-100 text-amber-600'],
            ['Workout Minutes', $stats['totalWorkoutMinutes'], 'fa-clock', 'bg-rose-100 text-rose-600'],
            ['Water ML', $stats['totalWaterMl'], 'fa-bottle-water', 'bg-sky-100 text-sky-600'],
        ] as [$label, $value, $icon, $color])
        <div class="admin-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ number_format($value) }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $color }}">
                    <i class="fa-solid {{ $icon }}"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

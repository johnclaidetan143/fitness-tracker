@extends('layouts.app')
@section('title', 'Workouts')
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Workouts</h1>
        <p class="text-slate-500 text-sm mt-1">Track and manage your training sessions</p>
    </div>
    <a href="{{ route('workouts.create') }}" class="btn-primary flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Log Workout
    </a>
</div>

@if($workouts->count())
<div class="grid gap-4">
    @foreach($workouts as $workout)
    @php
        $icons = ['running'=>'fa-person-running','pushups'=>'fa-hand-fist','plank'=>'fa-person'];
        $colors = ['running'=>'bg-emerald-100 text-emerald-600','pushups'=>'bg-orange-100 text-orange-600','plank'=>'bg-violet-100 text-violet-600'];
        $icon = $icons[$workout->type] ?? 'fa-dumbbell';
        $color = $colors[$workout->type] ?? 'bg-indigo-100 text-indigo-600';
    @endphp
    <div class="card hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 {{ $color }} rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid {{ $icon }} text-2xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <a href="{{ route('workouts.show', $workout) }}" class="font-bold text-slate-800 hover:text-indigo-600 transition-colors text-lg">
                            {{ $workout->name }}
                        </a>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-xs font-medium px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">{{ ucfirst($workout->type) }}</span>
                            <span class="text-xs text-slate-400">{{ $workout->workout_date->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="flex gap-1 flex-shrink-0">
                        <a href="{{ route('workouts.edit', $workout) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                        </a>
                        <form method="POST" action="{{ route('workouts.destroy', $workout) }}" onsubmit="return confirm('Delete this workout?')">
                            @csrf @method('DELETE')
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mt-3">
                    <div class="flex items-center gap-1.5 text-sm text-slate-500">
                        <div class="w-6 h-6 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-clock text-blue-500 text-xs"></i>
                        </div>
                        <span class="font-medium text-slate-700">{{ $workout->duration_minutes }}</span> min
                    </div>
                    <div class="flex items-center gap-1.5 text-sm text-slate-500">
                        <div class="w-6 h-6 bg-orange-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-fire text-orange-500 text-xs"></i>
                        </div>
                        <span class="font-medium text-slate-700">{{ $workout->calories_burned }}</span> kcal
                    </div>
                    @if($workout->steps > 0)
                    <div class="flex items-center gap-1.5 text-sm text-slate-500">
                        <div class="w-6 h-6 bg-green-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-shoe-prints text-green-500 text-xs"></i>
                        </div>
                        <span class="font-medium text-slate-700">{{ number_format($workout->steps) }}</span> steps
                    </div>
                    @endif
                    @if($workout->sets->count())
                    <div class="flex items-center gap-1.5 text-sm text-slate-500">
                        <div class="w-6 h-6 bg-violet-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-list text-violet-500 text-xs"></i>
                        </div>
                        <span class="font-medium text-slate-700">{{ $workout->sets->count() }}</span> exercises
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($workouts->hasPages())
<div class="mt-6">{{ $workouts->links() }}</div>
@endif

@else
<div class="card text-center py-20">
    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-dumbbell text-indigo-400 text-3xl"></i>
    </div>
    <h3 class="font-bold text-slate-700 text-lg mb-1">No workouts yet</h3>
    <p class="text-slate-400 text-sm mb-6">Start logging your training sessions to track your progress.</p>
    <a href="{{ route('workouts.create') }}" class="btn-primary inline-flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Log Your First Workout
    </a>
</div>
@endif

@endsection

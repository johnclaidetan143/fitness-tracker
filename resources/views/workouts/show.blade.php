@extends('layouts.app')
@section('title', 'Workout Detail')
@section('content')

@php
    $typeInfo = config('workout_types.' . $workout->type, ['label' => ucfirst($workout->type), 'icon' => 'fa-dumbbell', 'badge' => 'bg-indigo-100 text-indigo-600']);
@endphp

<div class="max-w-2xl">
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('workouts.index') }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 transition-all">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-800">{{ $workout->name }}</h1>
            <p class="text-slate-500 text-sm">{{ $workout->workout_date->format('l, F j, Y') }}</p>
        </div>
        <div class="w-14 h-14 {{ $typeInfo['badge'] }} rounded-2xl flex items-center justify-center">
            <i class="fa-solid {{ $typeInfo['icon'] }} text-2xl"></i>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="card text-center py-5">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                <i class="fa-solid fa-clock text-blue-600"></i>
            </div>
            <p class="text-2xl font-extrabold text-slate-800">{{ $workout->duration_minutes }}</p>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Minutes</p>
        </div>
        <div class="card text-center py-5">
            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                <i class="fa-solid fa-fire text-orange-600"></i>
            </div>
            <p class="text-2xl font-extrabold text-slate-800">{{ $workout->calories_burned }}</p>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Calories</p>
        </div>
        <div class="card text-center py-5">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                <i class="fa-solid fa-shoe-prints text-green-600"></i>
            </div>
            <p class="text-2xl font-extrabold text-slate-800">{{ number_format($workout->steps) }}</p>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Steps</p>
        </div>
        <div class="card text-center py-5">
            <div class="w-10 h-10 {{ $typeInfo['badge'] }} rounded-xl flex items-center justify-center mx-auto mb-2">
                <i class="fa-solid {{ $typeInfo['icon'] }}"></i>
            </div>
            <p class="text-2xl font-extrabold text-slate-800">{{ $typeInfo['label'] }}</p>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Type</p>
        </div>
    </div>

    {{-- Notes --}}
    @if($workout->notes)
    <div class="card mb-6">
        <div class="flex items-center gap-2 mb-2">
            <i class="fa-solid fa-note-sticky text-amber-500"></i>
            <h2 class="font-bold text-slate-700">Notes</h2>
        </div>
        <p class="text-slate-600 text-sm leading-relaxed">{{ $workout->notes }}</p>
    </div>
    @endif

    {{-- Exercises --}}
    @if($workout->sets->count())
    <div class="card mb-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fa-solid fa-list text-violet-500"></i>
            <h2 class="font-bold text-slate-800">Exercises</h2>
            <span class="ml-auto text-xs font-semibold bg-violet-100 text-violet-600 px-2 py-0.5 rounded-full">{{ $workout->sets->count() }} exercises</span>
        </div>
        <div class="space-y-3">
            @foreach($workout->sets as $i => $set)
            <div class="flex items-center gap-4 bg-slate-50 rounded-2xl px-4 py-3">
                <div class="w-8 h-8 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0 text-xs font-bold text-indigo-600">
                    {{ $i + 1 }}
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-slate-700">{{ $set->exercise_name }}</p>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <span class="bg-blue-100 text-blue-700 font-semibold px-2.5 py-1 rounded-lg">{{ $set->sets }} sets</span>
                    @if($set->reps)
                    <span class="bg-green-100 text-green-700 font-semibold px-2.5 py-1 rounded-lg">{{ $set->reps }} reps</span>
                    @endif
                    @if($set->weight_kg)
                    <span class="bg-orange-100 text-orange-700 font-semibold px-2.5 py-1 rounded-lg">{{ $set->weight_kg }} kg</span>
                    @endif
                    @if($set->duration_seconds)
                    <span class="bg-violet-100 text-violet-700 font-semibold px-2.5 py-1 rounded-lg">{{ $set->duration_seconds }}s</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Actions --}}
    <div class="flex gap-3">
        <a href="{{ route('workouts.edit', $workout) }}" class="btn-primary flex-1 text-center flex items-center justify-center gap-2">
            <i class="fa-solid fa-pen-to-square"></i> Edit Workout
        </a>
        <form method="POST" action="{{ route('workouts.destroy', $workout) }}" onsubmit="return confirm('Delete this workout?')">
            @csrf @method('DELETE')
            <button class="btn-danger flex items-center gap-2">
                <i class="fa-solid fa-trash"></i> Delete
            </button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Goals')
@section('content')

<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">🎯 My Goals</h1>

    <div class="card">
        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('goals.update') }}" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        <i class="fa-solid fa-shoe-prints text-indigo-500 mr-1"></i> Daily Steps Goal
                    </label>
                    <input type="number" name="daily_steps" value="{{ old('daily_steps', $goals->daily_steps) }}" min="100" required class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        <i class="fa-solid fa-droplet text-cyan-500 mr-1"></i> Daily Water (glasses)
                    </label>
                    <input type="number" name="daily_water_glasses" value="{{ old('daily_water_glasses', $goals->daily_water_glasses) }}" min="1" max="20" required class="input">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        <i class="fa-solid fa-clock text-green-500 mr-1"></i> Daily Workout (minutes)
                    </label>
                    <input type="number" name="daily_workout_minutes" value="{{ old('daily_workout_minutes', $goals->daily_workout_minutes) }}" min="5" required class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        <i class="fa-solid fa-calendar-check text-purple-500 mr-1"></i> Workout Days/Week
                    </label>
                    <input type="number" name="workout_days_per_week" value="{{ old('workout_days_per_week', $goals->workout_days_per_week) }}" min="1" max="7" required class="input">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">
                    <i class="fa-solid fa-weight-scale text-pink-500 mr-1"></i> Target Weight (kg) — optional
                </label>
                <input type="number" name="target_weight" value="{{ old('target_weight', $goals->target_weight) }}" min="20" max="300" step="0.1" class="input" placeholder="e.g. 70">
            </div>

            <button type="submit" class="btn-primary w-full">Save Goals</button>
        </form>
    </div>
</div>
@endsection

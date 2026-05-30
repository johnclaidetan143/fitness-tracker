@extends('layouts.app')
@section('title', 'Meals')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">🍽️ Meal Tracker</h1>
    <p class="text-slate-500 text-sm mt-1">Daily calorie goal: {{ number_format($calorieGoal) }} kcal</p>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Log Meal Form --}}
    <div class="card">
        <h2 class="font-bold text-slate-800 mb-4">Log a Meal</h2>
        @if($errors->any())
        <div class="mb-3 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('meals.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Food Name</label>
                <input type="text" name="name" required class="input" placeholder="e.g. Chicken Rice">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Meal Type</label>
                <select name="meal_type" class="input">
                    <option value="breakfast">🌅 Breakfast</option>
                    <option value="lunch">☀️ Lunch</option>
                    <option value="dinner">🌙 Dinner</option>
                    <option value="snack" selected>🍎 Snack</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Calories (kcal)</label>
                <input type="number" name="calories" min="0" required class="input" placeholder="e.g. 350">
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Protein (g)</label>
                    <input type="number" name="protein" min="0" step="0.1" class="input" placeholder="0">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Carbs (g)</label>
                    <input type="number" name="carbs" min="0" step="0.1" class="input" placeholder="0">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Fat (g)</label>
                    <input type="number" name="fat" min="0" step="0.1" class="input" placeholder="0">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Date</label>
                <input type="date" name="meal_date" value="{{ now()->toDateString() }}" required class="input">
            </div>
            <button type="submit" class="btn-primary w-full">Log Meal</button>
        </form>
    </div>

    {{-- Today's Summary + Meals --}}
    <div class="xl:col-span-2 space-y-5">

        {{-- Macros Summary --}}
        <div class="card">
            <h2 class="font-bold text-slate-800 mb-4">Today's Nutrition</h2>
            @php $calPct = min(100, round($todayCalories / $calorieGoal * 100)); @endphp
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-slate-600">Calories: <strong>{{ number_format($todayCalories) }}</strong> / {{ number_format($calorieGoal) }} kcal</span>
                <span class="text-sm font-bold {{ $calPct > 100 ? 'text-red-500' : 'text-indigo-600' }}">{{ $calPct }}%</span>
            </div>
            <div class="bg-slate-100 rounded-full h-3 mb-4">
                <div class="{{ $calPct > 100 ? 'bg-red-500' : 'bg-indigo-500' }} h-3 rounded-full" style="width: {{ min(100, $calPct) }}%"></div>
            </div>
            <div class="grid grid-cols-3 gap-3 text-center">
                <div class="bg-blue-50 rounded-xl p-3">
                    <p class="text-lg font-bold text-blue-600">{{ number_format($todayProtein, 1) }}g</p>
                    <p class="text-xs text-slate-500">Protein</p>
                </div>
                <div class="bg-yellow-50 rounded-xl p-3">
                    <p class="text-lg font-bold text-yellow-600">{{ number_format($todayCarbs, 1) }}g</p>
                    <p class="text-xs text-slate-500">Carbs</p>
                </div>
                <div class="bg-red-50 rounded-xl p-3">
                    <p class="text-lg font-bold text-red-500">{{ number_format($todayFat, 1) }}g</p>
                    <p class="text-xs text-slate-500">Fat</p>
                </div>
            </div>
        </div>

        {{-- Today's Meals --}}
        <div class="card">
            <h2 class="font-bold text-slate-800 mb-4">Today's Meals</h2>
            @php
                $mealIcons = ['breakfast' => '🌅', 'lunch' => '☀️', 'dinner' => '🌙', 'snack' => '🍎'];
            @endphp
            @forelse($todayMeals as $meal)
            <div class="flex items-center gap-3 py-3 border-b border-slate-100 last:border-0">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-lg">
                    {{ $mealIcons[$meal->meal_type] ?? '🍽️' }}
                </div>
                <div class="flex-1">
                    <p class="font-medium text-slate-700">{{ $meal->name }}</p>
                    <p class="text-xs text-slate-400">{{ ucfirst($meal->meal_type) }} · P:{{ $meal->protein }}g C:{{ $meal->carbs }}g F:{{ $meal->fat }}g</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-slate-700">{{ $meal->calories }} kcal</p>
                    <form method="POST" action="{{ route('meals.destroy', $meal) }}">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-400 hover:text-red-600">remove</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-slate-400">
                <p class="text-sm">No meals logged today</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

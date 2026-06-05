@extends('layouts.app')
@section('title', 'Workout Templates')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">📋 Workout Templates</h1>
    <p class="text-slate-500 text-sm mt-1">Save routines and reuse them quickly</p>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Create Template --}}
    <div class="card">
        <h2 class="font-bold text-slate-800 mb-4">Create Template</h2>
        <form method="POST" action="{{ route('templates.store') }}" class="space-y-4" id="templateForm">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Template Name</label>
                <input type="text" name="name" required class="input" placeholder="e.g. Chest Day">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Type</label>
                    <select name="type" class="input">
                        @foreach($workoutTypes as $type => $info)
                        <option value="{{ $type }}">{{ $info['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Est. Minutes</label>
                    <input type="number" name="estimated_minutes" value="30" min="1" required class="input">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">Exercises</label>
                <div id="exerciseList" class="space-y-3"></div>
                <button type="button" onclick="addExercise()"
                    class="mt-2 w-full border-2 border-dashed border-slate-200 text-slate-400 hover:border-indigo-400 hover:text-indigo-500 rounded-xl py-2 text-sm transition-all">
                    + Add Exercise
                </button>
            </div>

            <button type="submit" class="btn-primary w-full">Save Template</button>
        </form>
    </div>

    {{-- Templates List --}}
    <div class="xl:col-span-2">
        @forelse($templates as $t)
        <div class="card mb-4">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-bold text-slate-800">{{ $t->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $workoutTypes[$t->type]['label'] ?? ucfirst($t->type) }} · {{ $t->estimated_minutes }} min</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('workouts.create', ['template' => $t->id]) }}"
                        class="btn-primary text-sm py-1.5 px-3">Use</a>
                    <form method="POST" action="{{ route('templates.destroy', $t) }}">
                        @csrf @method('DELETE')
                        <button class="text-slate-400 hover:text-red-500 p-1.5 border border-slate-200 rounded-xl transition-all">
                            <i class="fa-solid fa-trash text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
            @if($t->exercises)
            <div class="space-y-1">
                @foreach($t->exercises as $ex)
                <div class="flex items-center gap-3 text-sm bg-slate-50 rounded-lg px-3 py-2">
                    <i class="fa-solid fa-dumbbell text-indigo-400 text-xs"></i>
                    <span class="font-medium text-slate-700">{{ $ex['name'] }}</span>
                    <span class="text-slate-400">{{ $ex['sets'] }} sets
                        @if(!empty($ex['reps'])) × {{ $ex['reps'] }} reps @endif
                        @if(!empty($ex['weight'])) @ {{ $ex['weight'] }}kg @endif
                    </span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <div class="card text-center py-16 text-slate-400">
            <i class="fa-solid fa-list-check text-5xl mb-3 block"></i>
            <p class="font-medium">No templates yet</p>
            <p class="text-sm mt-1">Create your first workout template</p>
        </div>
        @endforelse
    </div>
</div>

<script>
let exIndex = 0;
function addExercise() {
    const i = exIndex++;
    const div = document.createElement('div');
    div.className = 'bg-slate-50 rounded-xl p-3 space-y-2';
    div.innerHTML = `
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold text-slate-500">Exercise ${i+1}</span>
            <button type="button" onclick="this.closest('div.bg-slate-50').remove()" class="text-red-400 hover:text-red-600 text-xs">remove</button>
        </div>
        <input type="text" name="exercises[${i}][name]" required placeholder="Exercise name" class="input text-sm">
        <div class="grid grid-cols-3 gap-2">
            <div><label class="text-xs text-slate-500">Sets</label><input type="number" name="exercises[${i}][sets]" value="3" min="1" required class="input text-sm"></div>
            <div><label class="text-xs text-slate-500">Reps</label><input type="number" name="exercises[${i}][reps]" placeholder="0" min="0" class="input text-sm"></div>
            <div><label class="text-xs text-slate-500">Weight(kg)</label><input type="number" name="exercises[${i}][weight]" placeholder="0" min="0" step="0.5" class="input text-sm"></div>
        </div>`;
    document.getElementById('exerciseList').appendChild(div);
}
addExercise();
</script>
@endsection

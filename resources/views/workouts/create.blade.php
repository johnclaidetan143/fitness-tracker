@extends('layouts.app')
@section('title', 'Log Workout')
@section('content')

<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('workouts.index') }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 transition-all">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Log Workout</h1>
            <p class="text-slate-500 text-sm">Record your training session</p>
        </div>
    </div>

    {{-- Load from Template --}}
    @if($templates->count())
    <div class="card mb-5 border-2 border-dashed border-indigo-200 bg-indigo-50/50">
        <div class="flex items-center gap-2 mb-3">
            <i class="fa-solid fa-list-check text-indigo-500"></i>
            <label class="text-sm font-semibold text-indigo-700">Load from Template</label>
        </div>
        <select id="templateSelect" class="input bg-white" onchange="loadTemplate(this.value)">
            <option value="">— Select a template —</option>
            @foreach($templates as $t)
            <option value="{{ $t->id }}" data-template="{{ json_encode($t) }}">{{ $t->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="card">
        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('workouts.store') }}" class="space-y-6">
            @csrf

            {{-- Workout Type --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">Workout Type</label>
                <div class="grid grid-cols-3 gap-3">
                    @foreach(['running'=>['fa-person-running','Running','emerald'],'pushups'=>['fa-hand-fist','Push-ups','orange'],'plank'=>['fa-person','Plank','violet']] as $type => $info)
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="{{ $type }}" class="sr-only" {{ old('type','running') === $type ? 'checked' : '' }}>
                        <div class="type-card border-2 rounded-2xl p-3 text-center transition-all {{ old('type','running') === $type ? 'border-indigo-500 bg-indigo-50' : 'border-slate-200 hover:border-slate-300' }}">
                            <div class="w-10 h-10 rounded-xl bg-{{ $info[2] }}-100 flex items-center justify-center mx-auto mb-2">
                                <i class="fa-solid {{ $info[0] }} text-{{ $info[2] }}-600 text-lg"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-600">{{ $info[1] }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Name --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Workout Name</label>
                <input type="text" name="name" id="workoutName" value="{{ old('name','Morning Run') }}" required class="input" placeholder="e.g. Morning Run">
            </div>

            {{-- Duration & Calories --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <i class="fa-solid fa-clock text-blue-500 mr-1"></i> Duration (min)
                    </label>
                    <input type="number" name="duration_minutes" id="workoutDuration" value="{{ old('duration_minutes',30) }}" min="1" required class="input">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <i class="fa-solid fa-fire text-orange-500 mr-1"></i> Calories Burned
                    </label>
                    <input type="number" name="calories_burned" value="{{ old('calories_burned',0) }}" min="0" required class="input">
                </div>
            </div>

            {{-- Steps & Date --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <i class="fa-solid fa-shoe-prints text-green-500 mr-1"></i> Steps (optional)
                    </label>
                    <input type="number" name="steps" value="{{ old('steps',0) }}" min="0" class="input">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        <i class="fa-solid fa-calendar text-indigo-500 mr-1"></i> Date
                    </label>
                    <input type="date" name="workout_date" value="{{ old('workout_date', now()->toDateString()) }}" required class="input">
                </div>
            </div>

            {{-- Sets & Reps --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <label class="text-sm font-semibold text-slate-700">
                        <i class="fa-solid fa-list text-violet-500 mr-1"></i> Exercises (optional)
                    </label>
                    <button type="button" onclick="addSet()"
                        class="flex items-center gap-1.5 text-sm text-indigo-600 font-medium hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-all">
                        <i class="fa-solid fa-plus text-xs"></i> Add Exercise
                    </button>
                </div>
                <div id="setsList" class="space-y-3"></div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    <i class="fa-solid fa-note-sticky text-amber-500 mr-1"></i> Notes
                </label>
                <textarea name="notes" rows="3" class="input resize-none" placeholder="How did it go? Any observations...">{{ old('notes') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Save Workout
                </button>
                <a href="{{ route('workouts.index') }}" class="flex-1 text-center border border-slate-200 text-slate-600 px-5 py-2.5 rounded-xl hover:bg-slate-50 transition-all font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let setIndex = 0;

function addSet(name='', sets=3, reps=10, weight=0) {
    const i = setIndex++;
    const div = document.createElement('div');
    div.className = 'bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-3';
    div.innerHTML = `
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Exercise ${i+1}</span>
            <button type="button" onclick="this.closest('div.bg-slate-50').remove()" class="text-xs text-red-400 hover:text-red-600 font-medium flex items-center gap-1">
                <i class="fa-solid fa-xmark"></i> Remove
            </button>
        </div>
        <input type="text" name="sets[${i}][exercise_name]" value="${name}" required placeholder="Exercise name (e.g. Bench Press)" class="input text-sm">
        <div class="grid grid-cols-3 gap-3">
            <div>
                <label class="text-xs font-semibold text-slate-500 mb-1 block">Sets</label>
                <input type="number" name="sets[${i}][sets]" value="${sets}" min="1" required class="input text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-500 mb-1 block">Reps</label>
                <input type="number" name="sets[${i}][reps]" value="${reps}" min="0" class="input text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-500 mb-1 block">Weight (kg)</label>
                <input type="number" name="sets[${i}][weight_kg]" value="${weight}" min="0" step="0.5" class="input text-sm">
            </div>
        </div>`;
    document.getElementById('setsList').appendChild(div);
}

function loadTemplate(id) {
    if (!id) return;
    const opt = document.querySelector(`#templateSelect option[value="${id}"]`);
    const t = JSON.parse(opt.dataset.template);
    document.getElementById('workoutName').value = t.name;
    document.getElementById('workoutDuration').value = t.estimated_minutes;
    document.getElementById('setsList').innerHTML = '';
    setIndex = 0;
    if (t.exercises) t.exercises.forEach(ex => addSet(ex.name, ex.sets, ex.reps || 10, ex.weight || 0));
    document.querySelectorAll('input[name="type"]').forEach(r => {
        r.checked = r.value === t.type;
        r.nextElementSibling.classList.toggle('border-indigo-500', r.checked);
        r.nextElementSibling.classList.toggle('bg-indigo-50', r.checked);
        r.nextElementSibling.classList.toggle('border-slate-200', !r.checked);
    });
}

document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.addEventListener('change', () => {
        document.querySelectorAll('.type-card').forEach(c => {
            c.classList.remove('border-indigo-500','bg-indigo-50');
            c.classList.add('border-slate-200');
        });
        radio.nextElementSibling.classList.add('border-indigo-500','bg-indigo-50');
        radio.nextElementSibling.classList.remove('border-slate-200');
    });
});

@if(request('template'))
document.getElementById('templateSelect').value = '{{ request("template") }}';
loadTemplate('{{ request("template") }}');
@endif
</script>
@endsection

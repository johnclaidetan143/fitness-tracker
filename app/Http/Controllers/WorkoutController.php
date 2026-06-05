<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\WorkoutSet;
use App\Models\WorkoutTemplate;
use App\Services\FitnessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WorkoutController extends Controller
{
    public function index()
    {
        $workouts = Workout::where('user_id', Auth::id())->orderByDesc('workout_date')->paginate(10);
        return view('workouts.index', compact('workouts'));
    }

    public function create()
    {
        $templates = WorkoutTemplate::where('user_id', Auth::id())->get();
        $workoutTypes = config('workout_types');
        return view('workouts.create', compact('templates', 'workoutTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'type'             => ['required', Rule::in(array_keys(config('workout_types')))],
            'duration_minutes' => 'required|integer|min:1',
            'calories_burned'  => 'required|integer|min:0',
            'steps'            => 'nullable|integer|min:0',
            'notes'            => 'nullable|string',
            'workout_date'     => 'required|date',
            'sets'             => 'nullable|array',
            'sets.*.exercise_name'     => 'required_with:sets|string',
            'sets.*.sets'              => 'required_with:sets|integer|min:1',
            'sets.*.reps'              => 'nullable|integer|min:0',
            'sets.*.weight_kg'         => 'nullable|numeric|min:0',
            'sets.*.duration_seconds'  => 'nullable|integer|min:0',
        ]);

        $data['user_id'] = Auth::id();
        $data['steps']   = $data['steps'] ?? 0;
        $workout = Workout::create($data);

        if (!empty($data['sets'])) {
            foreach ($data['sets'] as $set) {
                $workout->sets()->create([
                    'exercise_name'    => $set['exercise_name'],
                    'sets'             => $set['sets'],
                    'reps'             => $set['reps'] ?? 0,
                    'weight_kg'        => $set['weight_kg'] ?? 0,
                    'duration_seconds' => $set['duration_seconds'] ?? 0,
                ]);
            }
        }

        $user = Auth::user();
        FitnessService::updateStreak($user);
        FitnessService::updatePersonalRecords($user, $data['workout_date']);
        FitnessService::checkAchievements($user);

        return redirect()->route('workouts.index')->with('success', 'Workout logged successfully!');
    }

    public function show(Workout $workout)
    {
        abort_if($workout->user_id !== Auth::id(), 403);
        $workout->load('sets');
        return view('workouts.show', compact('workout'));
    }

    public function edit(Workout $workout)
    {
        abort_if($workout->user_id !== Auth::id(), 403);
        $workout->load('sets');
        $workoutTypes = config('workout_types');
        return view('workouts.edit', compact('workout', 'workoutTypes'));
    }

    public function update(Request $request, Workout $workout)
    {
        abort_if($workout->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'type'             => ['required', Rule::in(array_keys(config('workout_types')))],
            'duration_minutes' => 'required|integer|min:1',
            'calories_burned'  => 'required|integer|min:0',
            'steps'            => 'nullable|integer|min:0',
            'notes'            => 'nullable|string',
            'workout_date'     => 'required|date',
            'sets'             => 'nullable|array',
            'sets.*.exercise_name'    => 'required_with:sets|string',
            'sets.*.sets'             => 'required_with:sets|integer|min:1',
            'sets.*.reps'             => 'nullable|integer|min:0',
            'sets.*.weight_kg'        => 'nullable|numeric|min:0',
            'sets.*.duration_seconds' => 'nullable|integer|min:0',
        ]);

        $data['steps'] = $data['steps'] ?? 0;
        $workout->update($data);
        $workout->sets()->delete();

        if (!empty($data['sets'])) {
            foreach ($data['sets'] as $set) {
                $workout->sets()->create([
                    'exercise_name'    => $set['exercise_name'],
                    'sets'             => $set['sets'],
                    'reps'             => $set['reps'] ?? 0,
                    'weight_kg'        => $set['weight_kg'] ?? 0,
                    'duration_seconds' => $set['duration_seconds'] ?? 0,
                ]);
            }
        }

        FitnessService::updatePersonalRecords(Auth::user(), $data['workout_date']);
        return redirect()->route('workouts.index')->with('success', 'Workout updated!');
    }

    public function destroy(Workout $workout)
    {
        abort_if($workout->user_id !== Auth::id(), 403);
        $workout->delete();
        return back()->with('success', 'Workout deleted.');
    }
}

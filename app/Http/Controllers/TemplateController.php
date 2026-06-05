<?php

namespace App\Http\Controllers;

use App\Models\WorkoutTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = WorkoutTemplate::where('user_id', Auth::id())->orderByDesc('created_at')->get();
        $workoutTypes = config('workout_types');
        return view('templates.index', compact('templates', 'workoutTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'type'               => ['required', Rule::in(array_keys(config('workout_types')))],
            'estimated_minutes'  => 'required|integer|min:1',
            'exercises'          => 'required|array|min:1',
            'exercises.*.name'   => 'required|string',
            'exercises.*.sets'   => 'required|integer|min:1',
            'exercises.*.reps'   => 'nullable|integer|min:0',
            'exercises.*.weight' => 'nullable|numeric|min:0',
        ]);

        WorkoutTemplate::create([
            'user_id'           => Auth::id(),
            'name'              => $data['name'],
            'type'              => $data['type'],
            'estimated_minutes' => $data['estimated_minutes'],
            'exercises'         => $data['exercises'],
        ]);

        return back()->with('success', 'Template saved!');
    }

    public function destroy(WorkoutTemplate $template)
    {
        abort_if($template->user_id !== Auth::id(), 403);
        $template->delete();
        return back()->with('success', 'Template deleted.');
    }
}

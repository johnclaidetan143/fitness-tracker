<?php

namespace App\Http\Controllers;

use App\Models\BmiLog;
use App\Models\BodyMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\FitnessService;

class BodyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bmiLogs = BmiLog::where('user_id', $user->id)->orderBy('log_date')->get();
        $measurements = BodyMeasurement::where('user_id', $user->id)->orderByDesc('measured_date')->take(10)->get();
        $latest = $measurements->first();

        $currentBmi = null;
        if ($user->weight && $user->height) {
            $currentBmi = round($user->weight / (($user->height / 100) ** 2), 1);
        }

        return view('body.index', compact('bmiLogs', 'measurements', 'latest', 'currentBmi', 'user'));
    }

    public function storeBmi(Request $request)
    {
        $data = $request->validate([
            'weight' => 'required|numeric|min:20|max:300',
            'height' => 'required|numeric|min:50|max:250',
            'log_date' => 'required|date',
        ]);

        $bmi = round($data['weight'] / (($data['height'] / 100) ** 2), 1);

        BmiLog::create([
            'user_id'  => Auth::id(),
            'weight'   => $data['weight'],
            'height'   => $data['height'],
            'bmi'      => $bmi,
            'log_date' => $data['log_date'],
        ]);

        // Update user profile weight/height
        Auth::user()->update(['weight' => $data['weight'], 'height' => $data['height']]);
        FitnessService::checkAchievements(Auth::user());
        return back()->with('success', 'BMI logged!');
    }

    public function storeMeasurement(Request $request)
    {
        $data = $request->validate([
            'waist'         => 'nullable|numeric|min:0',
            'chest'         => 'nullable|numeric|min:0',
            'arms'          => 'nullable|numeric|min:0',
            'legs'          => 'nullable|numeric|min:0',
            'hips'          => 'nullable|numeric|min:0',
            'neck'          => 'nullable|numeric|min:0',
            'measured_date' => 'required|date',
        ]);

        $data['user_id'] = Auth::id();
        BodyMeasurement::create($data);

        return back()->with('success', 'Measurements saved!');
    }

    public function destroyMeasurement(BodyMeasurement $bodyMeasurement)
    {
        abort_if($bodyMeasurement->user_id !== Auth::id(), 403);
        $bodyMeasurement->delete();
        return back()->with('success', 'Entry deleted.');
    }
}

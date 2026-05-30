<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $earned = $user->achievements()->withPivot('earned_at')->get()->keyBy('key');
        $all = Achievement::all();
        return view('achievements.index', compact('earned', 'all'));
    }
}

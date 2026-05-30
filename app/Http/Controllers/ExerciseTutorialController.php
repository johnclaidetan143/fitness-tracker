<?php

namespace App\Http\Controllers;

class ExerciseTutorialController extends Controller
{
    public function index()
    {
        $tutorials = [
            [
                'name' => 'Push-up',
                'type' => 'Strength',
                'level' => 'Beginner',
                'minutes' => 8,
                'icon' => 'fa-hand-fist',
                'color' => 'bg-orange-100 text-orange-600',
                'focus' => 'Chest, shoulders, triceps, and core',
                'video_url' => asset('videos/push-up.mp4'),
                'steps' => [
                    'Start in a high plank with hands slightly wider than shoulder width.',
                    'Keep your body straight from head to heels and tighten your core.',
                    'Lower your chest toward the floor while keeping elbows around 45 degrees.',
                    'Press the floor away until your arms are straight again.',
                ],
                'tips' => [
                    'Use knee push-ups if full push-ups feel too hard.',
                    'Do not let your hips sag or rise too high.',
                ],
            ],
            [
                'name' => 'Plank',
                'type' => 'Core',
                'level' => 'Beginner',
                'minutes' => 5,
                'icon' => 'fa-person',
                'color' => 'bg-violet-100 text-violet-600',
                'focus' => 'Abs, lower back, shoulders, and glutes',
                'video_url' => asset('videos/plank.mp4'),
                'steps' => [
                    'Place forearms on the floor with elbows under your shoulders.',
                    'Step both feet back and keep your legs straight.',
                    'Squeeze your glutes and brace your stomach like you are about to cough.',
                    'Hold the position while breathing slowly and steadily.',
                ],
                'tips' => [
                    'Begin with 20 to 30 seconds and add time gradually.',
                    'Stop if you feel sharp lower-back pain.',
                ],
            ],
            [
                'name' => 'Running Warm-up',
                'type' => 'Cardio',
                'level' => 'Beginner',
                'minutes' => 7,
                'icon' => 'fa-person-running',
                'color' => 'bg-sky-100 text-sky-600',
                'focus' => 'Hips, ankles, calves, and breathing rhythm',
                'video_url' => asset('videos/running.mp4'),
                'steps' => [
                    'Walk briskly for two minutes to raise your heart rate.',
                    'Do 10 leg swings per side while holding a wall or rail.',
                    'March in place with high knees for 30 seconds.',
                    'Jog lightly for two minutes before starting your run.',
                ],
                'tips' => [
                    'Keep the warm-up easy, not tiring.',
                    'Use shorter strides if your calves feel tight.',
                ],
            ],
        ];

        return view('tutorials.index', compact('tutorials'));
    }
}

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
            [
                'name' => 'Back Kick',
                'type' => 'Lower Body',
                'level' => 'Beginner',
                'minutes' => 6,
                'icon' => 'fa-shoe-prints',
                'color' => 'bg-rose-100 text-rose-600',
                'focus' => 'Glutes, hamstrings, hips, and balance',
                'video_url' => asset('videos/back-kick.mp4'),
                'steps' => [
                    'Stand tall with feet hip-width apart and brace your core.',
                    'Shift your weight to one leg while keeping your chest lifted.',
                    'Kick the opposite leg back with control and squeeze your glute.',
                    'Return the foot to the floor and repeat before switching sides.',
                ],
                'tips' => [
                    'Keep the movement slow instead of swinging your leg.',
                    'Hold a wall or chair if you need help balancing.',
                ],
            ],
            [
                'name' => 'Jumping Jacks',
                'type' => 'Cardio',
                'level' => 'Beginner',
                'minutes' => 5,
                'icon' => 'fa-person-rays',
                'color' => 'bg-amber-100 text-amber-600',
                'focus' => 'Full body coordination, calves, shoulders, and heart rate',
                'video_url' => asset('videos/jumping-jacks.mp4'),
                'steps' => [
                    'Start standing with arms by your sides and feet together.',
                    'Jump both feet out while sweeping your arms overhead.',
                    'Land softly with knees slightly bent.',
                    'Jump back to the starting position and keep a steady rhythm.',
                ],
                'tips' => [
                    'Step side to side instead of jumping for a low-impact version.',
                    'Keep your breathing relaxed and your shoulders away from your ears.',
                ],
            ],
            [
                'name' => 'Lift Your Legs High',
                'type' => 'Cardio',
                'level' => 'Beginner',
                'minutes' => 5,
                'icon' => 'fa-person-walking',
                'color' => 'bg-cyan-100 text-cyan-600',
                'focus' => 'Hip flexors, core, quads, and running posture',
                'video_url' => asset('videos/lift-your-legs-high.mp4'),
                'steps' => [
                    'Stand tall with your feet under your hips.',
                    'Drive one knee upward toward hip height while bracing your core.',
                    'Lower the foot under control and switch sides.',
                    'Pump your arms naturally as you build a smooth rhythm.',
                ],
                'tips' => [
                    'Stay upright instead of leaning backward.',
                    'Move slower if your balance starts to wobble.',
                ],
            ],
            [
                'name' => 'Mountain Climber',
                'type' => 'Core',
                'level' => 'Intermediate',
                'minutes' => 7,
                'icon' => 'fa-mountain',
                'color' => 'bg-lime-100 text-lime-600',
                'focus' => 'Abs, shoulders, hip flexors, and conditioning',
                'video_url' => asset('videos/mountain-climber.mp4'),
                'steps' => [
                    'Start in a high plank with hands under your shoulders.',
                    'Keep your body straight and pull one knee toward your chest.',
                    'Return that foot back to plank as the other knee drives forward.',
                    'Alternate legs while keeping your hips as steady as possible.',
                ],
                'tips' => [
                    'Start slow and controlled before increasing speed.',
                    'Press the floor away to avoid sinking into your shoulders.',
                ],
            ],
            [
                'name' => 'Reverse Lunge',
                'type' => 'Lower Body',
                'level' => 'Beginner',
                'minutes' => 8,
                'icon' => 'fa-arrow-rotate-left',
                'color' => 'bg-teal-100 text-teal-600',
                'focus' => 'Quads, glutes, hamstrings, and single-leg control',
                'video_url' => asset('videos/reverse-lunge.mp4'),
                'steps' => [
                    'Stand tall with feet hip-width apart.',
                    'Step one foot backward and lower until both knees bend comfortably.',
                    'Push through the front foot to return to standing.',
                    'Repeat on the same side or alternate legs each rep.',
                ],
                'tips' => [
                    'Keep your front knee tracking in line with your toes.',
                    'Take a smaller step back if your balance feels unstable.',
                ],
            ],
            [
                'name' => 'Squat Pause',
                'type' => 'Strength',
                'level' => 'Intermediate',
                'minutes' => 8,
                'icon' => 'fa-dumbbell',
                'color' => 'bg-fuchsia-100 text-fuchsia-600',
                'focus' => 'Quads, glutes, hips, and squat control',
                'video_url' => asset('videos/squat-pause.mp4'),
                'steps' => [
                    'Stand with feet about shoulder-width apart.',
                    'Push your hips back and bend your knees to lower into a squat.',
                    'Pause briefly at the bottom while keeping your chest lifted.',
                    'Drive through your feet to stand back up with control.',
                ],
                'tips' => [
                    'Keep your heels planted throughout the movement.',
                    'Pause only as low as you can maintain good posture.',
                ],
            ],
            [
                'name' => 'Switch Lunges',
                'type' => 'Cardio Strength',
                'level' => 'Intermediate',
                'minutes' => 7,
                'icon' => 'fa-arrows-rotate',
                'color' => 'bg-blue-100 text-blue-600',
                'focus' => 'Leg power, glutes, quads, and coordination',
                'video_url' => asset('videos/switch-lunges.mp4'),
                'steps' => [
                    'Start in a lunge position with both knees bent.',
                    'Jump upward and switch your legs in the air.',
                    'Land softly in a lunge with the opposite foot forward.',
                    'Continue alternating while keeping your torso upright.',
                ],
                'tips' => [
                    'Use reverse lunges instead if jumping feels too intense.',
                    'Land quietly to protect your knees and ankles.',
                ],
            ],
        ];

        return view('tutorials.index', compact('tutorials'));
    }
}

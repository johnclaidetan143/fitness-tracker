<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            ['key' => 'first_workout',      'name' => 'First Step',         'description' => 'Log your first workout',              'icon' => 'fa-dumbbell',        'color' => 'indigo'],
            ['key' => 'streak_3',           'name' => '3-Day Streak',       'description' => 'Work out 3 days in a row',            'icon' => 'fa-fire',            'color' => 'orange'],
            ['key' => 'streak_7',           'name' => 'Week Warrior',       'description' => 'Work out 7 days in a row',            'icon' => 'fa-fire-flame-curved','color' => 'red'],
            ['key' => 'streak_30',          'name' => 'Monthly Legend',     'description' => 'Work out 30 days in a row',           'icon' => 'fa-crown',           'color' => 'yellow'],
            ['key' => 'steps_10k',          'name' => '10K Steps',          'description' => 'Walk 10,000 steps in a day',          'icon' => 'fa-shoe-prints',     'color' => 'green'],
            ['key' => 'steps_50k',          'name' => 'Step Master',        'description' => 'Walk 50,000 steps total',             'icon' => 'fa-person-walking',  'color' => 'teal'],
            ['key' => 'calories_500',       'name' => 'Calorie Crusher',    'description' => 'Burn 500 calories in a day',          'icon' => 'fa-bolt',            'color' => 'orange'],
            ['key' => 'water_goal',         'name' => 'Hydration Hero',     'description' => 'Hit water goal 7 days in a row',      'icon' => 'fa-droplet',         'color' => 'cyan'],
            ['key' => 'workouts_10',        'name' => 'Dedicated',          'description' => 'Log 10 total workouts',               'icon' => 'fa-medal',           'color' => 'purple'],
            ['key' => 'workouts_50',        'name' => 'Fitness Fanatic',    'description' => 'Log 50 total workouts',               'icon' => 'fa-trophy',          'color' => 'yellow'],
            ['key' => 'meal_logged',        'name' => 'Nutrition Aware',    'description' => 'Log your first meal',                 'icon' => 'fa-utensils',        'color' => 'green'],
            ['key' => 'profile_complete',   'name' => 'All Set Up',         'description' => 'Complete your profile',               'icon' => 'fa-user-check',      'color' => 'blue'],
        ];

        foreach ($achievements as $a) {
            Achievement::updateOrCreate(['key' => $a['key']], $a);
        }
    }
}

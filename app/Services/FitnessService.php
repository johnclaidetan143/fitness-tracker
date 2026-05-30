<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\PersonalRecord;
use App\Models\Streak;
use App\Models\User;
use App\Models\Workout;
use App\Models\WaterLog;

class FitnessService
{
    public static function updateStreak(User $user): void
    {
        $streak = $user->streak ?? Streak::create(['user_id' => $user->id]);
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        if ($streak->last_activity_date?->toDateString() === $today) return;

        if ($streak->last_activity_date?->toDateString() === $yesterday) {
            $streak->current_streak += 1;
        } else {
            $streak->current_streak = 1;
        }

        $streak->longest_streak = max($streak->longest_streak, $streak->current_streak);
        $streak->last_activity_date = $today;
        $streak->save();

        self::checkAchievements($user);
    }

    public static function updatePersonalRecords(User $user, string $date): void
    {
        $types = [
            'most_steps'      => Workout::where('user_id', $user->id)->whereDate('workout_date', $date)->sum('steps'),
            'most_calories'   => Workout::where('user_id', $user->id)->whereDate('workout_date', $date)->sum('calories_burned'),
            'longest_workout' => Workout::where('user_id', $user->id)->whereDate('workout_date', $date)->sum('duration_minutes'),
            'most_water'      => WaterLog::where('user_id', $user->id)->whereDate('log_date', $date)->sum('glasses'),
        ];

        foreach ($types as $type => $value) {
            if ($value <= 0) continue;
            $record = PersonalRecord::where('user_id', $user->id)->where('type', $type)->first();
            if (!$record || $value > $record->value) {
                PersonalRecord::updateOrCreate(
                    ['user_id' => $user->id, 'type' => $type],
                    ['value' => $value, 'record_date' => $date]
                );
            }
        }
    }

    public static function checkAchievements(User $user): void
    {
        $earned = $user->achievements->pluck('key')->toArray();
        $toAward = [];

        $totalWorkouts = $user->workouts()->count();
        $streak = $user->streak;
        $totalSteps = $user->workouts()->sum('steps');

        if ($totalWorkouts >= 1 && !in_array('first_workout', $earned))   $toAward[] = 'first_workout';
        if ($totalWorkouts >= 10 && !in_array('workouts_10', $earned))    $toAward[] = 'workouts_10';
        if ($totalWorkouts >= 50 && !in_array('workouts_50', $earned))    $toAward[] = 'workouts_50';
        if ($totalSteps >= 50000 && !in_array('steps_50k', $earned))      $toAward[] = 'steps_50k';
        if ($streak && $streak->current_streak >= 3 && !in_array('streak_3', $earned))   $toAward[] = 'streak_3';
        if ($streak && $streak->current_streak >= 7 && !in_array('streak_7', $earned))   $toAward[] = 'streak_7';
        if ($streak && $streak->current_streak >= 30 && !in_array('streak_30', $earned)) $toAward[] = 'streak_30';

        // Check today's stats
        $today = now()->toDateString();
        $todaySteps    = Workout::where('user_id', $user->id)->whereDate('workout_date', $today)->sum('steps');
        $todayCalories = Workout::where('user_id', $user->id)->whereDate('workout_date', $today)->sum('calories_burned');

        if ($todaySteps >= 10000 && !in_array('steps_10k', $earned))      $toAward[] = 'steps_10k';
        if ($todayCalories >= 500 && !in_array('calories_500', $earned))  $toAward[] = 'calories_500';

        // Profile complete
        if ($user->weight && $user->height && $user->age && !in_array('profile_complete', $earned)) $toAward[] = 'profile_complete';

        // Meal logged
        if ($user->meals()->count() >= 1 && !in_array('meal_logged', $earned)) $toAward[] = 'meal_logged';

        if (!empty($toAward)) {
            $ids = Achievement::whereIn('key', $toAward)->pluck('id');
            foreach ($ids as $id) {
                $user->achievements()->syncWithoutDetaching([$id => ['earned_at' => now()]]);
            }
        }
    }
}

<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\BmiLog;
use App\Models\Meal;
use App\Models\PersonalRecord;
use App\Models\Streak;
use App\Models\SleepLog;
use App\Models\User;
use App\Models\Workout;
use App\Models\WaterLog;

class FitnessService
{
    public static function updateStreak(User $user): void
    {
        $streak = $user->streak ?? Streak::create(['user_id' => $user->id]);
        $today     = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        if ($streak->last_activity_date?->toDateString() === $today) return;

        if ($streak->last_activity_date?->toDateString() === $yesterday) {
            $streak->current_streak += 1;
        } else {
            $streak->current_streak = 1;
        }

        $streak->longest_streak    = max($streak->longest_streak, $streak->current_streak);
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
        $user->load('achievements');
        $earned  = $user->achievements->pluck('key')->toArray();
        $toAward = [];

        $totalWorkouts = $user->workouts()->count();
        $streak        = $user->streak;
        $totalSteps    = $user->workouts()->sum('steps');
        $today         = now()->toDateString();

        $todaySteps    = Workout::where('user_id', $user->id)->whereDate('workout_date', $today)->sum('steps');
        $todayCalories = Workout::where('user_id', $user->id)->whereDate('workout_date', $today)->sum('calories_burned');

        // Workouts
        if ($totalWorkouts >= 1   && !in_array('first_workout', $earned))  $toAward[] = 'first_workout';
        if ($totalWorkouts >= 10  && !in_array('workouts_10', $earned))    $toAward[] = 'workouts_10';
        if ($totalWorkouts >= 50  && !in_array('workouts_50', $earned))    $toAward[] = 'workouts_50';
        if ($totalWorkouts >= 100 && !in_array('workouts_100', $earned))   $toAward[] = 'workouts_100';

        // Streaks
        if ($streak && $streak->current_streak >= 3  && !in_array('streak_3', $earned))  $toAward[] = 'streak_3';
        if ($streak && $streak->current_streak >= 7  && !in_array('streak_7', $earned))  $toAward[] = 'streak_7';
        if ($streak && $streak->current_streak >= 30 && !in_array('streak_30', $earned)) $toAward[] = 'streak_30';

        // Steps
        if ($todaySteps >= 10000  && !in_array('steps_10k', $earned))   $toAward[] = 'steps_10k';
        if ($totalSteps >= 50000  && !in_array('steps_50k', $earned))   $toAward[] = 'steps_50k';
        if ($totalSteps >= 100000 && !in_array('steps_100k', $earned))  $toAward[] = 'steps_100k';

        // Calories
        if ($todayCalories >= 500  && !in_array('calories_500', $earned))  $toAward[] = 'calories_500';
        if ($todayCalories >= 1000 && !in_array('calories_1000', $earned)) $toAward[] = 'calories_1000';

        // Early bird — workout logged before 7AM
        $earlyWorkout = Workout::where('user_id', $user->id)
            ->whereTime('created_at', '<', '07:00:00')
            ->exists();
        if ($earlyWorkout && !in_array('early_bird', $earned)) $toAward[] = 'early_bird';

        // Weekend warrior — worked out both Sat & Sun this week
        $satDate = now()->startOfWeek()->addDays(6)->toDateString(); // Sunday
        $sunDate = now()->startOfWeek()->addDays(5)->toDateString(); // Saturday
        $workedSat = Workout::where('user_id', $user->id)->whereDate('workout_date', $sunDate)->exists();
        $workedSun = Workout::where('user_id', $user->id)->whereDate('workout_date', $satDate)->exists();
        if ($workedSat && $workedSun && !in_array('weekend_warrior', $earned)) $toAward[] = 'weekend_warrior';

        // Profile complete
        if ($user->weight && $user->height && $user->age && !in_array('profile_complete', $earned)) $toAward[] = 'profile_complete';

        // Meals
        if ($user->meals()->count() >= 1 && !in_array('meal_logged', $earned)) $toAward[] = 'meal_logged';

        $todayMeals = Meal::where('user_id', $user->id)->whereDate('meal_date', $today)->count();
        if ($todayMeals >= 3 && !in_array('meals_3_in_day', $earned)) $toAward[] = 'meals_3_in_day';

        // Meals 7 days in a row
        $mealStreak = 0;
        for ($i = 0; $i < 7; $i++) {
            $date = now()->subDays($i)->toDateString();
            if (Meal::where('user_id', $user->id)->whereDate('meal_date', $date)->exists()) {
                $mealStreak++;
            } else break;
        }
        if ($mealStreak >= 7 && !in_array('meals_7days', $earned)) $toAward[] = 'meals_7days';

        // Water first log
        if (WaterLog::where('user_id', $user->id)->exists() && !in_array('first_water', $earned)) $toAward[] = 'first_water';

        // Sleep 7+ hours for 7 days
        $sleepStreak = 0;
        for ($i = 0; $i < 7; $i++) {
            $date = now()->subDays($i)->toDateString();
            $log  = SleepLog::where('user_id', $user->id)->whereDate('sleep_date', $date)->first();
            if ($log && $log->hours >= 7) {
                $sleepStreak++;
            } else break;
        }
        if ($sleepStreak >= 7 && !in_array('sleep_7days', $earned)) $toAward[] = 'sleep_7days';

        // BMI logged
        if (BmiLog::where('user_id', $user->id)->exists() && !in_array('bmi_logged', $earned)) $toAward[] = 'bmi_logged';

        if (!empty($toAward)) {
            $ids = Achievement::whereIn('key', $toAward)->pluck('id');
            foreach ($ids as $id) {
                $user->achievements()->syncWithoutDetaching([$id => ['earned_at' => now()]]);
            }
        }
    }
}

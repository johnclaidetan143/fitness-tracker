<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WaterController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\SleepController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExerciseTutorialController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/workouts', [AdminController::class, 'workouts'])->name('admin.workouts');
        Route::get('/meals', [AdminController::class, 'meals'])->name('admin.meals');
        Route::get('/water-logs', [AdminController::class, 'waterLogs'])->name('admin.water-logs');
        Route::get('/achievements', [AdminController::class, 'achievements'])->name('admin.achievements');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    });

    Route::resource('workouts', WorkoutController::class);
    Route::get('/exercise-tutorials', [ExerciseTutorialController::class, 'index'])->name('tutorials.index');

    Route::get('/water', [WaterController::class, 'index'])->name('water.index');
    Route::post('/water', [WaterController::class, 'store'])->name('water.store');
    Route::delete('/water/{waterLog}', [WaterController::class, 'destroy'])->name('water.destroy');

    Route::get('/goals', [GoalController::class, 'edit'])->name('goals.edit');
    Route::put('/goals', [GoalController::class, 'update'])->name('goals.update');

    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/meals', [MealController::class, 'index'])->name('meals.index');
    Route::post('/meals', [MealController::class, 'store'])->name('meals.store');
    Route::delete('/meals/{meal}', [MealController::class, 'destroy'])->name('meals.destroy');

    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
    Route::get('/records', [RecordController::class, 'index'])->name('records.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

Route::get('/sleep', [SleepController::class, 'index'])->name('sleep.index');
    Route::post('/sleep', [SleepController::class, 'store'])->name('sleep.store');
    Route::delete('/sleep/{sleepLog}', [SleepController::class, 'destroy'])->name('sleep.destroy');

    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::post('/templates', [TemplateController::class, 'store'])->name('templates.store');
    Route::delete('/templates/{template}', [TemplateController::class, 'destroy'])->name('templates.destroy');
});

Route::get('/', fn() => view('welcome'));

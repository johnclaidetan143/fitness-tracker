<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workout_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained()->cascadeOnDelete();
            $table->string('exercise_name');
            $table->integer('sets')->default(1);
            $table->integer('reps')->default(0);
            $table->decimal('weight_kg', 6, 2)->default(0);
            $table->integer('duration_seconds')->default(0); // for plank/timed
            $table->timestamps();
        });

        Schema::create('bmi_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->decimal('bmi', 5, 2);
            $table->date('log_date');
            $table->timestamps();
        });

        Schema::create('body_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('waist', 5, 2)->nullable();
            $table->decimal('chest', 5, 2)->nullable();
            $table->decimal('arms', 5, 2)->nullable();
            $table->decimal('legs', 5, 2)->nullable();
            $table->decimal('hips', 5, 2)->nullable();
            $table->decimal('neck', 5, 2)->nullable();
            $table->date('measured_date');
            $table->timestamps();
        });

        Schema::create('sleep_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('hours', 4, 2);
            $table->string('quality')->default('good'); // poor, fair, good, excellent
            $table->date('sleep_date');
            $table->timestamps();
        });

        Schema::create('workout_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('running');
            $table->text('exercises'); // JSON
            $table->integer('estimated_minutes')->default(30);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_templates');
        Schema::dropIfExists('sleep_logs');
        Schema::dropIfExists('body_measurements');
        Schema::dropIfExists('bmi_logs');
        Schema::dropIfExists('workout_sets');
    }
};

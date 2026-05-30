<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('running'); // running, pushups, plank
            $table->integer('duration_minutes');
            $table->integer('calories_burned')->default(0);
            $table->integer('steps')->default(0);
            $table->text('notes')->nullable();
            $table->date('workout_date');
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('workouts'); }
};

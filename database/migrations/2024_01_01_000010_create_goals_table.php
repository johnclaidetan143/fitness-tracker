<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('daily_steps')->default(10000);
            $table->decimal('target_weight', 5, 2)->nullable();
            $table->integer('workout_days_per_week')->default(3);
            $table->integer('daily_water_glasses')->default(8);
            $table->integer('daily_workout_minutes')->default(30);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('goals'); }
};

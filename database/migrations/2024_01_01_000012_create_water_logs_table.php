<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('water_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('glasses')->default(1);
            $table->integer('ml')->default(250);
            $table->date('log_date');
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('water_logs'); }
};

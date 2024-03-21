<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('camlapses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('description');
            $table->Integer('fph');
            $table->tinyInteger('between_hour_start')->nullable();
            $table->tinyInteger('between_hour_end')->nullable();
            $table->tinyInteger('memory_period')->nullable();//day/week/month/year
            $table->dateTime('stop_datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camlapses');
    }
};

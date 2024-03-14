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
            $table->string('name', 255);
            $table->string('description');
            $table->Integer('fph');
            $table->Integer('max_frames')->default(10000)->nullable();
            $table->tinyInteger('between_hour_start')->nullable();
            $table->tinyInteger('between_hour_end')->nullable();
            $table->dateTime('end_datetime')->nullable();
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

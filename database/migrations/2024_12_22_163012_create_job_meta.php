<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_meta', function (Blueprint $table) {
            $table->id();
            $table->integer('camlapse_id', false, true)->index();
            $table->string('type', 255);
            $table->integer('duration', false, true)->nullable();
            $table->integer('timestamp')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_meta');
    }
};

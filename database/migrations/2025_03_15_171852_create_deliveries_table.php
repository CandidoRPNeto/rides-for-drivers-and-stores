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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('run_id')->nullable();
            $table->uuid('rating_id')->nullable();
            $table->uuid('destiny_id');
            $table->string('code');
            $table->integer('position')->default(0);
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
            $table->foreign('run_id')->references('id')->on('runs');
            $table->foreign('rating_id')->references('id')->on('ratings');
            $table->foreign('destiny_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};

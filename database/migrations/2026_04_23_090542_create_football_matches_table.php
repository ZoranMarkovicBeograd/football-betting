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
        Schema::create('football_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_id')->unique();

            $table->foreignId('competition_id')->constrained()->cascadeOnDelete();

            $table->unsignedBigInteger('home_team_api_id')->nullable();
            $table->unsignedBigInteger('away_team_api_id')->nullable();

            $table->string('home_team_name')->nullable();
            $table->string('away_team_name')->nullable();

            $table->dateTime('utc_date')->nullable();
            $table->string('status')->nullable();
            $table->string('matchday')->nullable();

            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('football_matches');
    }
};

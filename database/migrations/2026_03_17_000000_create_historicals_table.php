<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('milestone_user');
        Schema::dropIfExists('milestones');

        Schema::create('historicals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('img')->nullable();
            $table->text('body')->nullable();
            $table->date('event_date')->nullable();
            $table->timestamps();
        });

        Schema::create('historical_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historical_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_user');
        Schema::dropIfExists('historicals');
    }
};

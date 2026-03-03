<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Para "(Develop) Padron..."
            $table->string('organization')->nullable(); // Para "Gobierno..."
            $table->string('status')->nullable(); // Para Activo, Caido
            $table->string('priority')->nullable(); // Para Baja, Critica
            $table->string('technology')->nullable()->default('php'); // Para php
            $table->string('repository_url')->nullable(); // Para github.com...
            $table->string('environment_type')->nullable(); // Para Desarrollo, Produccion
            $table->string('framework')->nullable()->default('Laravel'); // Para Laravel
            $table->string('app_url_or_note')->nullable(); // Para URL o mensajes de error
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
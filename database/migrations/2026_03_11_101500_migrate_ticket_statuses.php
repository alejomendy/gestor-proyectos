<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('tickets')->where('status', 'backlog')->update(['status' => 'Por asignar']);
        DB::table('tickets')->where('status', 'todo')->update(['status' => 'Por asignar']);
        DB::table('tickets')->where('status', 'doing')->update(['status' => 'en proceso']);
        DB::table('tickets')->where('status', 'review')->update(['status' => 'En revision']);
        DB::table('tickets')->where('status', 'to_production')->update(['status' => 'Produccion']);
        DB::table('tickets')->where('status', 'stopped')->update(['status' => 'Parado']);
        DB::table('tickets')->where('status', 'done')->update(['status' => 'Terminado']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Not easily reversible as we collapsed backlog/todo
    }
};

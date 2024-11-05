<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Verificar si la columna no existe antes de agregarla
            if (!Schema::hasColumn('events', 'event_type_id')) {
                $table->bigInteger('event_type_id')->unsigned();
                $table->foreign('event_type_id')->references('id')->on('event_types');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};

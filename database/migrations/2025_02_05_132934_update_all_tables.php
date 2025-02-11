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
    public function up()
    {
        // Habilitar la extensión uuid-ossp en PostgreSQL (si no está habilitada)
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        $tables = [
            'ambulancias',
            'bosems',
            'cupons',
            'elementosambs',
            'herramientasambs',
            'lista_chequeos'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->uuid('uuid')->default(DB::raw('uuid_generate_v4()'))->unique();
            });
        }
    }

    public function down()
    {
        $tables = [
            'ambulancias',
            'bosems',
            'cupons',
            'elementosambs',
            'herramientasambs',
            'lista_chequeos'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntradaSaidaIntervaloToVagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vagas', function (Blueprint $table) {
            $table->dropColumn(['horario', 'intervalo']);
        });

        Schema::table('vagas', function (Blueprint $table) {
            $table->time('hora_entrada')->after('expediente');
            $table->time('hora_saida')->after('hora_entrada');
            $table->time('tempo_intervalo')->after('hora_saida');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vagas', function (Blueprint $table) {
            $table->dropColumn(['hora_entrada', 'hora_saida', 'tempo_intervalo']);
        });

        Schema::table('vagas', function (Blueprint $table) {
            $table->string('horario')->after('expediente');
            $table->string('intervalo')->after('horario');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntradaSaidaIntervaloToEstagioHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estagio_horarios', function (Blueprint $table) {
            $table->dropColumn(['hora_inicio', 'hora_fim']);
        });

        Schema::table('estagio_horarios', function (Blueprint $table) {
            $table->time('hora_entrada')->after('dia_semana');
            $table->time('hora_saida')->after('hora_entrada');
            $table->time('tempo_intervalo')->nullable()->after('hora_saida');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estagio_horarios', function (Blueprint $table) {
            $table->dropColumn(['hora_entrada', 'hora_saida', 'tempo_intervalo']);
        });

        Schema::table('estagio_horarios', function (Blueprint $table) {
            $table->time('hora_inicio')->after('dia_semana');
            $table->time('hora_fim')->after('hora_inicio');
        });
    }
}

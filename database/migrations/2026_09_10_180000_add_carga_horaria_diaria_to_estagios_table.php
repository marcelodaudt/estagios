<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCargaHorariaDiariaToEstagiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estagios', function (Blueprint $table) {
            $table->string('cargahorasdiaria')->nullable()->after('cargaminutos');
            $table->string('cargaminutosdiaria')->nullable()->after('cargahorasdiaria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estagios', function (Blueprint $table) {
            $table->dropColumn(['cargahorasdiaria', 'cargaminutosdiaria']);
        });
    }
}

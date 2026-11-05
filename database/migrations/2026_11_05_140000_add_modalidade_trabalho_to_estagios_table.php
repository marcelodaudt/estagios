<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModalidadeTrabalhoToEstagiosTable extends Migration
{
    /**
     * Modalidade de trabalho do estágio: Presencial, Home-office ou Híbrido.
     * Nullable para não afetar os estágios cadastrados anteriormente.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estagios', function (Blueprint $table) {
            $table->string('modalidade_trabalho')->nullable()->after('tipoestagio');
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
            $table->dropColumn('modalidade_trabalho');
        });
    }
}

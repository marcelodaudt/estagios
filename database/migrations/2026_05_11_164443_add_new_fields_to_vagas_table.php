<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToVagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vagas', function (Blueprint $table) {
            $table->string('curso')->after('titulo'); 
            $table->text('requisitos')->after('beneficios');
            $table->string('contato_email')->after('contato');
            $table->string('contato_telefone')->nullable()->after('contato_email');
            $table->string('contato_site')->nullable()->after('contato_telefone');
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
            // Importante: Sempre defina como reverter a migration
            $table->dropColumn(['curso', 'requisitos', 'contato_email', 'contato_telefone', 'contato_site']);
        });
    }
}

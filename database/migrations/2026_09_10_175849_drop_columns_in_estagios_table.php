<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsInEstagiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estagios', function (Blueprint $table) {
            $table->dropColumn(['controlehorario', 'supervisao', 'interacao', 'enderecoedias', 'pandemiahomeoffice', 'pandemiamedidas']);
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
            $table->text('controlehorario')->nullable();
            $table->text('supervisao')->nullable();
            $table->text('interacao')->nullable();
            $table->text('enderecoedias')->nullable();
            $table->string('pandemiahomeoffice');
            $table->text('pandemiamedidas')->nullable();
        });
    }
}

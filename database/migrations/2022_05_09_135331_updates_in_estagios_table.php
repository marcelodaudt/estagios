<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatesInEstagiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estagios', function (Blueprint $table) {
            $table->string('tipoestagio');
            $table->text('valorbolsa')->nullable()->change();            
            $table->text('tipobolsa')->nullable()->change();
            $table->text('seguradora')->nullable()->change();
            $table->text('numseguro')->nullable()->change();
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
            $table->dropColumn('tipoestagio');
            $table->text('valorbolsa');            
            $table->text('tipobolsa');
            $table->text('seguradora');
            $table->text('numseguro');
        });
    }
}

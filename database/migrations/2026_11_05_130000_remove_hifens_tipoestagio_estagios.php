<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveHifensTipoestagioEstagios extends Migration
{
    private $de_para = [
        'Obrigatório Não-remunerado' => 'Obrigatório Não Remunerado',
        'Não-obrigatório Remunerado' => 'Não Obrigatório Remunerado',
    ];

    /**
     * Atualiza a modalidade dos estágios já cadastrados para os novos valores, sem hífens.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->de_para as $antigo => $novo) {
            DB::table('estagios')->where('tipoestagio', $antigo)->update(['tipoestagio' => $novo]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->de_para as $antigo => $novo) {
            DB::table('estagios')->where('tipoestagio', $novo)->update(['tipoestagio' => $antigo]);
        }
    }
}

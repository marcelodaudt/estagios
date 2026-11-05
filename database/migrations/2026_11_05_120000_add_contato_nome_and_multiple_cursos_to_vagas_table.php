<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddContatoNomeAndMultipleCursosToVagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * - Adiciona o campo "Nome do contato" (contato_nome).
     * - Converte o campo "curso" para permitir mais de um curso por vaga
     *   (passa a armazenar um array JSON em uma coluna text).
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vagas', function (Blueprint $table) {
            $table->string('contato_nome')->nullable()->after('contato');
            $table->text('curso')->nullable()->change();
        });

        // Converte os valores existentes (string simples) para array JSON
        DB::table('vagas')->select('id', 'curso')->orderBy('id')->each(function ($vaga) {
            if ($vaga->curso === null || $vaga->curso === '') {
                $cursos = [];
            } else {
                $decodificado = json_decode($vaga->curso, true);
                $cursos = is_array($decodificado) ? $decodificado : [$vaga->curso];
            }
            DB::table('vagas')->where('id', $vaga->id)->update(['curso' => json_encode($cursos)]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Mantém apenas o primeiro curso de cada vaga
        DB::table('vagas')->select('id', 'curso')->orderBy('id')->each(function ($vaga) {
            $cursos = json_decode($vaga->curso ?? '', true);
            $curso = is_array($cursos) ? ($cursos[0] ?? '') : (string) $vaga->curso;
            DB::table('vagas')->where('id', $vaga->id)->update(['curso' => $curso]);
        });

        Schema::table('vagas', function (Blueprint $table) {
            $table->dropColumn('contato_nome');
            $table->string('curso')->nullable(false)->change();
        });
    }
}

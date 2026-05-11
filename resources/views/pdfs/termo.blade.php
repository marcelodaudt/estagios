@extends('pdfs.fflch')

@section('content')

<div style="width:100%; border-width: 1px; border-style: solid; border-color: #000; text-align: center; padding: 0px;">
    <b>TERMO DE CIÊNCIA</b>
</div>

<br><br><br><br><br>

<div style="text-align: justify;">
    <p style="text-indent : 1em;">Os documentos, impressos e assinados, devem ser entregues com pelo menos 10 dias úteis
        antes do início estágio.</p>
    <br>
    <p style="text-indent : 1em;">É obrigatória a entrega de um relatório pessoal (digitado, datado, assinado e com no
        mínimo 7 linhas) no término desse estágio, relatando sua experiência no período.</p>
    <br>
    <p style="text-indent : 1em; font-weight: bold">Uma via deste termo de Ciência deve ser entregue com o Termo de
        Compromisso e Plano de Estágio.</p>
    <br>
    <p>Ciência d{{ $estagio->artigo_definido }}
        alun{{ $estagio->artigo_definido}}
        {{ $estagio->nome }}:</p>
</div>

<br><br>

<div>
    _______________________________________________<br>
    <b>{{ $estagio->nome }}</b><br>
    Nº USP: <b>{{ $estagio->numero_usp }}</b><br>
    <b>{{ $estagio->curso }}</b>
</div>

<p style="page-break-after: always;"></p>

<div style="border-width: 1px; border-style: solid; border-color: #000; text-align: center; padding: 0px;">
    <b>TERMO DE COMPROMISSO</b><br>
    <b>{{ $estagio->tipoestagio }}</b>
</div>

<div style="text-align: justify;">
    <p style="text-indent : 1em;">UNIVERSIDADE DE SÃO PAULO, estabelecida à Rua da Reitoria, nº 109, na cidade de 
        São Paulo, estado de São Paulo, CNPJ nº 63.025.530/0001-04, através da ESCOLA DE COMUNICAÇÕES E ARTES, 
        com endereço à Av. Prof. Lúcio Martins Rodrigues, 443 - Cidade Universitária - Butantã, na cidade de São 
        Paulo, Estado de São Paulo, CNPJ 63.025.530/0021-58, representada por sua Diretora Profa. Dra. Maria Clotilde
        Perez Rodrigues, adiante designada INTERVENIENTE e o(a) ESTAGIÁRIO(A) <b>{{ $estagio->nome }}</b>, 
        estudante, residente a <b>@foreach ($estagio->endereco as $campos) {{ $campos }}@endforeach</b>, portador
        da cédula de identidade {{ $estagio->tipo_identidade }} n° <b>{{ $estagio->identidade }}</b> e CPF nº
        <b>{{ $estagio->cpf }}</b>, aluno do Curso de <b>{{ $estagio->curso }}</b>, matrícula nº  
        <b>{{ $estagio->numero_usp }}</b>, e como CONCEDENTE <b>{{ $estagio->empresa->nome }}</b> (empresa ou instituição de
        ensino), com endereço à <b>{{ $estagio->empresa->endereco }}</b>, CEP {{ $estagio->empresa->cep }}, CNPJ
        <b>{{ $estagio->empresa->cnpj }}</b>, celebram o presente TERMO DE COMPROMISSO DE ESTÁGIO, nos termos da Lei
        nº 11.788/2008, conforme as condições a seguir:
    </p>
    <p>1. O estágio terá duração (não superior a um ano) de <b>{{ $estagio->duracao }}</b> a começar em
        <b>{{$estagio->data_inicial}}</b> terminando em <b>{{$estagio->data_final}}</b> que poderá ser eventualmente
        prorrogado, ou modificado por documento complementar, desde que não exceda o prazo de 2 (dois) anos de
        vigência do estágio, computadas as renovações. Eventualmente qualquer das partes poderá solicitar a rescisão,
        por escrito, com 5 (cinco) dias de antecedência. O(A) estagiário(a) não terá vínculo empregatício de qualquer
        natureza com a CONCEDENTE em razão deste TERMO DE COMPROMISSO.
    </p>
    <p>2. No período de estágio, o(a) ESTAGIÁRIO(A) cumprirá <b>{{ $estagio->cargahoras }} horas semanais</b>.
        O horário de estágio será das <b>{{ $estagio->horario }}</b>, combinado
        de acordo com as conveniências mútuas, ressalvadas as horas de aulas, provas e outros trabalhos didáticos, assim
        como as limitações dos meios de transportes.</p>
    <p>2.1. Nos períodos de avaliação do rendimento escolar, conforme informado pelo estágiário, a jornada de atividade
        em estágio será reduzida à metade, sem desconto no valor da bolsa.</p>
    <p>3. A CONCEDENTE designa o Sr(a). <b>{{ $estagio->nome_do_supervisor_estagio }}</b>, que ocupa o cargo de
        <b>{{$estagio->cargo_do_supervisor_estagio}}</b>,
        para ser o(a) SUPERVISOR(a) INTERNO(a) do Estágio que será por ele programado.
    </p>
    <p>4. O ESTAGIÁRIO se obriga a cumprir fielmente a programação do estágio, salvo impossibilidade da qual a
        CONCEDENTE será previamente informada.
    </p>
    <p>5. O ESTAGIÁRIO receberá BOLSA DE COMPLEMENTAÇÃO EDUCACIONAL DE <b>R$ {{ $estagio->valorbolsa }}</b>
        {{ $estagio->tipobolsa}} e
        auxílio-transporte no
        valor de R$ <b>{{ $estagio->auxiliotransporte }} {{ $estagio->especifiquevt }}</b>. A importância referente à
        bolsa, por
        não ter natureza
        salarial, não se enquadra no regime do FGTS (Fundo de Garantia por Tempo de Serviço) e não sofrerá qualquer
        desconto, inclusive
        previdenciário, exceção feita à retenção do imposto de renda na fonte, quando devido.
    </p>
    <p>5.1.O estagiário terá direito, sempre que o estágio tenha duração igual ou superior a 1 (um) ano, a um período de
        recesso de 30 (trinta) dias, a ser gozado preferencialmente durante suas férias escolares.
    </p>
    <p>5.2. O recesso de que trata este artigo deverá ser remunerado quando o estagiário receber bolsa ou outra forma de
        contraprestação.
    </p>
    <p>5.3. Os dias de recesso previstos neste artigo serão concedidos de maneira proporcional, nos casos de o estágio
        ter duração inferior a 1(um) ano.
    </p>
    <p>6. Quando, em razão da programação do estágio, o aluno tiver despesas extras, a CONCEDENTE providenciará o seu
        pronto reembolso.
    </p>
    <p>7. O ESTAGIÁRIO se obriga a cumprir as normas e os regulamentos internos da CONCEDENTE, pela inobservância dessas
        normas, o ESTAGIÁRIO responderá por perdas e danos e a rescisão do compromisso.
    </p>
    <p>7.1 O estagiário declara ter conhecimento e estar de acordo que toda contribuição prática ou intelectual
        desenvolvida em função de suas tarefas como estagiário são de propriedade da Empresa Concedente, não tendo
        direito de subtrair, na totalidade ou em parte, programas, documentos ou arquivos.
    </p>
    <p>8. O ESTAGIÁRIO está segurado contra acidentes pessoais, pela Apólice de Seguros <b>nº
            {{ $estagio->numseguro }}</b>,
        que está compatível com valores de mercado, da <b>{{ $estagio->seguradora }}</b>.
    </p>
    <p>9. O ESTAGIÁRIO deverá informar de imediato e por escrito à CONCEDENTE qualquer fato que interrompa, suspenda ou
        cancele sua matrícula na instituição de Ensino INTERVENIENTE, ficando ele responsável por quaisquer despesas
        causadas pela ausência dessa informação.
    </p>
    <p>10. A Instituição de Ensino INTERVENIENTE supervisionará o estágio de conformidade com os seus regulamentos
        internos, ficando o ESTAGIÁRIO sujeito a essa regulamentação.
    </p>
    <p>10.1.Como supervisora, a INSTITUIÇÃO DE ENSINO INTERVENIENTE indica
        <b>{{ \App\Models\Parecerista::nomePresidente() }}</b>.
    </p>
    <p>E, por estarem de acordo com os termos do presente instrumento, <b>as partes o assinam em 03 (três) vias</b>, na
        presença de duas testemunhas para todos os fins e efeitos de direito.
    </p>
</div>

<div style="page-break-inside: avoid;">

<div style="text-align: center;">São Paulo, {{ Carbon\Carbon::now()->formatLocalized('%d/%m/%Y') }}</div>

<br><br>

<div style="font-style: italic; font-weight: bold">
    ________________________________________________<br>
    {{ $estagio->empresa->nome }}
    <br><br><br>
    _______________________________________________<br>
    {{ $estagio->nome }}<br><br><br>
    ________________________________________________<br>
    {{ \App\Models\Parecerista::nomePresidente() }}<br>
    Presidente da CG ECA/USP
</div>

<div><br><br>
    <b>TESTEMUNHAS:</b><br><br>
    _______________________________________________<br><br>
    _______________________________________________
</div>

</div>

<p style="page-break-after: always;"></p>

<div style="border-width: 1px; border-style: solid; border-color: #000; text-align: center; padding: 0px;">
    <b>PLANO DE ESTÁGIO</b><br>
    <b>Modalidade: {{ $estagio->tipoestagio }}</b><br>
</div>

<br>

<div style="text-align: justify; page-break-inside: auto;">
    <b>Solicitação: ESTÁGIO NOVO</b><br>
    <b>Nome d{{ $estagio->artigo_definido}} Estagiári{{ $estagio->artigo_definido }}:</b> {{ $estagio->nome }}<br>
    <b>Nº USP:</b> {{ $estagio->numero_usp }}<br>
    <b>Curso:</b> {{ $estagio->curso }}<br>
    <b>Período:</b> {{ $estagio->periodo }}<br>
    <b>Semestre:</b> {{ $estagio->semestre_atual }}º<br>
    <b>E-mail:</b> {{ $estagio->email }}<br>
    <b>Nome da Empresa:</b> {{ $estagio->empresa->nome }}<br>
    <b>Área de atuação da Empresa:</b> {{ $estagio->empresa->area_de_atuacao }}<br>
    <b>Nome do supervisor(a) interno(a) do Estágio na Empresa:</b> {{ $estagio->nome_do_supervisor_estagio }}<br>
    <b>Telefone do Supervisor:</b> {{ $estagio->telefone_do_supervisor_estagio }} / {{ $estagio->telefone_de_contato }},
    <b>E-mail do Supervisor:</b> {{ $estagio->email_do_supervisor_estagio }}<br>
    <b>Data de início do estágio:</b> {{$estagio->data_inicial}}<br>
    <b>Data do término do estágio:</b> {{$estagio->data_final}}<br>
    <b>Horário do Estágio:</b> {{ $estagio->horario }}<br>
    <b>Carga horária semanal:</b> {{ $estagio->cargahoras }}h{{ $estagio->cargaminutos }} semanais<br>
    <b>Duração em meses (em casos excepcionais inferiores a 6 meses, a empresa deverá incluir justificativa circunstanciada
    que será avaliada pelo Supervisor Geral de Estágios):</b> {{ $estagio->duracao }}<br>
    <b>Justificativa:</b> {{ $estagio->justificativa }}<br>
    <b>Número de horas por semana:</b> {{ $estagio->cargahoras }}h{{ $estagio->cargaminutos }} semanais<br>
    <b>Valor da Bolsa:</b> R$ {{ $estagio->valorbolsa }} {{ $estagio->tipobolsa }}<br>
    <b>Valor do auxílio transporte:</b> R$ {{ $estagio->auxiliotransporte }} {{ $estagio->especifiquevt }}<br>
    <b>Descrição detalhada das atividades a serem desenvolvidas pelo estagiário, com a finalidade de permitir a avaliação
    da Comissão de Estágios:</b> {{ $estagio->atividades }}<br>
    <b>NO CASO DE ESTÁGIO DOMICILIAR</b><br>
    <b>Como se dará o controle diário dos horários de início e encerramento das atividades?</b> {{ $estagio->controlehorario }}<br>
    <b>Como se dará a supervisão interna (por parte da empresa) do estagiário?</b> {{ $estagio->supervisao}}<br>
    <b>Como se dará a interação do estagiário com o ambiente e com os demais colaboradores da empresa? Haverá
    deslocamento para a empresa? Se sim, quais dias?</b> {{ $estagio->interacao }}<br>
    <b>Qual o endereço e em quais dias será realizado o estágio?</b>{{$estagio->enderecoedias}}<br>
    <b>INFORMAÇÕES RELATIVAS A ESTÁGIO NO PERÍODO DE PANDEMIA</b><br>
    <b>O estágio será realizado em home-office?:</b> {{$estagio->pandemiahomeoffice}}<br>
    <b>Em caso do estágio não ser home-office, quais as medidas sanitárias adotadas pela empresa são:</b> {{$estagio->pandemiamedidas}}<br>
</div>

<div style="page-break-inside: avoid;">

<br><br>

<div style="text-align: center;">São Paulo, {{ Carbon\Carbon::now()->formatLocalized('%d/%m/%Y') }}</div>

<br><br>

    <br>
    _______________________________________________<br>
    {{ $estagio->empresa->nome_do_representante }}<br>
    Representante da {{ $estagio->empresa->nome }}<br><br>
    _______________________________________________<br>
    {{ $estagio->nome }}<br><br>
    _______________________________________________<br>
    {{ \App\Models\Parecerista::nomePresidente() }} <br>
    Presidente da CG – ECA/USP

    <br><br><br>

<div>
    <p><b>Contato:</b> {{ $estagio->nome_de_contato }}, Telefone: {{ $estagio->telefone_de_contato }} <br>
    <b>E-mail da empresa:</b> {{ $estagio->empresa->email }}
    </p>
</div>

</div>

<p style="page-break-after: never;"></p>

@endsection('content')

@section('footer')
<div style="text-align: initial; font-weight: bold;">
    OS DOCUMENTOS (TERMO E PLANO) DEVEM SER ENTREGUES PARA ANÁLISE 10 DIAS ÚTEIS ANTES DO INÍCIO DO ESTÁGIO.<br>
    AO FINAL DE CADA SEMESTRE DE REALIZAÇÃO DO ESTÁGIO DEVERÁ SER ENTREGUE UM RELATÓRIO PESSOAL, NOS TERMOS DA LEI
    11.788, DA RESOLUÇÃO USP N. 5528.
</div>
@endsection

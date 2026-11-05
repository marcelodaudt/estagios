@section('javascripts_bottom')
    <script src="{{asset('/js/estagios.js')}}"></script>
@endsection('javascripts_bottom')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/estagios.css')}}">
@endsection('styles')

<br>
<h4>Estágio</h4>
<br>
O período máximo do estágio inicial deve ser de 12 meses, prorrogável através de termo
aditivo por até 12 meses.
<br><br>

<div class="card">
    <div class="card-header">Informações Gerais</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="numero_usp" class="required">Número USP: </label>
                    <input type="number" class="form-control" id="numero_usp" name="numero_usp" value="{{old('numero_usp',$estagio->numero_usp)}}">
                    <div id="info"></div>
                </div>
            </div>
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="tipoestagio" class="required">Especifique a modalidade do estágio: </label>
                    <select name="tipoestagio" class="form-control" id="tipoestagio">
                        <option value="" selected="">- Selecione -</option>
                            @foreach ($estagio->tipoestagioOptions() as $option)
                                @if (old('tipoestagio') == '' and isset($estagio->tipoestagio) )
                                    <option value="{{$option}}" {{ ( $estagio->tipoestagio == $option) ? 'selected' : ''}}>
                                        {{$option}}
                                    </option>
                                @else
                                    <option value="{{$option}}" {{ ( old('tipoestagio') == $option) ? 'selected' : ''}}>
                                        {{$option}}
                                    </option>
                                @endif
                            @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="modalidade_trabalho" class="required">Modalidade de trabalho: </label>
                    <select name="modalidade_trabalho" class="form-control" id="modalidade_trabalho">
                        <option value="">- Selecione -</option>
                        @foreach ($estagio->modalidadeTrabalhoOptions() as $option)
                            <option value="{{$option}}" {{ old('modalidade_trabalho', $estagio->modalidade_trabalho) == $option ? 'selected' : '' }}>{{$option}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="departamento" class="required">Escolha o Departamento: </label>
                    <select name="departamento" class="form-control" id="departamento">
                        <option value="" selected="">- Selecione -</option>
                            @foreach ($estagio->departamentoOptions() as $option)
                                @if (old('departamento') == '' and isset($estagio->departamento) )
                                    <option value="{{$option}}" {{ ( $estagio->departamento == $option) ? 'selected' : ''}}>
                                        {{$option}}
                                    </option>
                                @else
                                    <option value="{{$option}}" {{ ( old('departamento') == $option) ? 'selected' : ''}}>
                                        {{$option}}
                                    </option>
                                @endif
                            @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="valorbolsa" class="required">Valor da Bolsa (R$): </label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                        <input type="text" class="form-control money" id="valorbolsa" name="valorbolsa" placeholder="0,00" value="{{old('valorbolsa', \App\Models\Estagio::formataMoeda($estagio->valorbolsa))}}">
                    </div>
                </div>
            </div>
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="tipobolsa" class="required" required>Especifique a natureza do pagamento da bolsa: </label>
                    <select name="tipobolsa" class="form-control" id="tipobolsa">
                        <option value="" selected="">- Selecione -</option>
                            @foreach ($estagio->tipobolsaOptions() as $option)
                                @if (old('tipobolsa') == '' and isset($estagio->tipobolsa) )
                                    <option value="{{$option}}" {{ ( $estagio->tipobolsa == $option) ? 'selected' : ''}}>
                                        {{$option}}
                                    </option>
                                @else
                                    <option value="{{$option}}" {{ ( old('tipobolsa') == $option) ? 'selected' : ''}}>
                                        {{$option}}
                                    </option>
                                @endif 
                            @endforeach
                    </select> 
                </div>
            </div>
        </div>
        <div class="form-group">
        <label for="atividades" class="required">Descrição detalhada das atividades a serem desenvolvidas pelo estagiário: </label>
            <textarea name="atividades" rows="5" cols="60">{{old('atividades',$estagio->atividades)}}</textarea>
        </div>
        <br>
    </div>
</div>

<hr>

<div class="card">
    <div class="card-header">Período do Estágio</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm form-group">
                <div class="form-group">
                <label for="data_inicial" class="required">Data de início do Estágio: </label>
                    <input type="text" class="form-control datepicker @error('data_inicial') is-invalid @enderror" id="data_inicial" name="data_inicial" value="{{old('data_inicial',$estagio->data_inicial)}}" data-min-dias="{{ \App\Http\Requests\EstagioRequest::ANTECEDENCIA_MINIMA_DIAS }}" onblur="calculodata(this);">
                    @error('data_inicial')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">A data de início deve ser, no mínimo, 7 dias após a data de hoje (a partir de {{ \App\Http\Requests\EstagioRequest::dataInicialMinima()->format('d/m/Y') }}). Não são aceitas datas retroativas.</small>
                </div>
            </div>    
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="data_final" class="required">Data de término do Estágio: </label>
                    <input type="text" class="form-control datepicker" id="data_final" name="data_final" value="{{old('data_final',$estagio->data_final)}}" onblur="calculodata(this);">
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="card">
    <div class="card-header">Carga Horária</div>
    <div class="card-body">
        <div class="alert alert-danger" role="alert">
            <strong>Atenção:</strong> O horário do estágio deverá ser compatível com o horário escolar do(a) estudante e respeitar o limite máximo de 6 horas diárias e 30 horas semanais, conforme a legislação vigente.
        </div>
        @php
            $tipoHorario = old('tipo_horario', $estagio->tipo_horario);
            $horarioPadrao = $estagio->horario_padrao ?? ['entrada' => '', 'saida' => '', 'intervalo' => ''];
        @endphp
        <div class="alert alert-warning" role="alert">
            <strong>Escolha uma das duas formas de preenchimento da carga horária (obrigatório):</strong>
            <ul class="mb-0">
                <li><b>Mesmo horário todos os dias:</b> informe uma única entrada, saída e tempo de intervalo, que serão <b>aplicados de segunda a sexta-feira</b>.</li>
                <li><b>Horário detalhado por dia:</b> informe o horário de cada dia da semana, quando <b>houver horários diferenciados entre os dias</b> ou <b>atividades aos sábados</b>.</li>
            </ul>
            Em ambos os casos, valem os limites de 6 horas diárias e 30 horas semanais.
        </div>

        <div class="form-group">
            <label class="required">Forma de preenchimento da carga horária:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipo_horario" id="tipo_horario_padrao" value="padrao" onchange="alternaTipoHorario()" {{ $tipoHorario == 'padrao' ? 'checked' : '' }}>
                <label class="form-check-label" for="tipo_horario_padrao">Mesmo horário todos os dias (segunda a sexta-feira)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipo_horario" id="tipo_horario_por_dia" value="por_dia" onchange="alternaTipoHorario()" {{ $tipoHorario == 'por_dia' ? 'checked' : '' }}>
                <label class="form-check-label" for="tipo_horario_por_dia">Horário detalhado por dia da semana</label>
            </div>
        </div>

        <div id="bloco-horario-padrao" style="{{ $tipoHorario == 'padrao' ? '' : 'display: none;' }}">
            <label class="required">Informe o horário do estágio, que será aplicado de segunda a sexta-feira, de forma que não haja conflito com o horário das aulas:</label>
            <div class="row">
                <div class="col-sm form-group">
                    <label for="horario_padrao_entrada">Entrada:</label>
                    <input type="time" class="form-control" id="horario_padrao_entrada" name="horario_padrao[entrada]" oninput="calculaTotalPadrao()" value="{{ old('horario_padrao.entrada', $horarioPadrao['entrada']) }}">
                </div>
                <div class="col-sm form-group">
                    <label for="horario_padrao_saida">Saída:</label>
                    <input type="time" class="form-control" id="horario_padrao_saida" name="horario_padrao[saida]" oninput="calculaTotalPadrao()" value="{{ old('horario_padrao.saida', $horarioPadrao['saida']) }}">
                </div>
                <div class="col-sm form-group">
                    <label for="horario_padrao_intervalo">Tempo de Intervalo:</label>
                    <input type="time" class="form-control" id="horario_padrao_intervalo" name="horario_padrao[intervalo]" oninput="calculaTotalPadrao()" value="{{ old('horario_padrao.intervalo', $horarioPadrao['intervalo']) }}">
                </div>
                <div class="col-sm form-group">
                    <label for="total-padrao">Total diário:</label>
                    <input type="text" class="form-control" id="total-padrao" readonly>
                </div>
            </div>
        </div>

        <div id="bloco-horario-por-dia" style="{{ $tipoHorario == 'por_dia' ? '' : 'display: none;' }}">
            <label class="required">Informe o horário do estágio para cada dia da semana, incluindo eventuais horários diferenciados, de forma que não haja conflito com o horário das aulas:</label>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Dia da semana</th>
                            <th>Entrada</th>
                            <th>Saída</th>
                            <th>Tempo de Intervalo</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estagio->diasSemanaOptions() as $dia => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td><input type="time" class="form-control" name="horarios[{{$dia}}][entrada]" oninput="calculaTotalHorario('{{$dia}}')" value="{{ old("horarios.$dia.entrada", $estagio->horarios_por_dia[$dia]['entrada']) }}"></td>
                                <td><input type="time" class="form-control" name="horarios[{{$dia}}][saida]" oninput="calculaTotalHorario('{{$dia}}')" value="{{ old("horarios.$dia.saida", $estagio->horarios_por_dia[$dia]['saida']) }}"></td>
                                <td><input type="time" class="form-control" name="horarios[{{$dia}}][intervalo]" oninput="calculaTotalHorario('{{$dia}}')" value="{{ old("horarios.$dia.intervalo", $estagio->horarios_por_dia[$dia]['intervalo']) }}"></td>
                                <td><input type="text" class="form-control" id="total-{{$dia}}" value="{{ $estagio->horarios_por_dia[$dia]['total'] }}" readonly></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <small class="form-text text-muted">O Total é calculado automaticamente (Saída menos Entrada, descontado o Tempo de Intervalo). Deixe a linha em branco nos dias sem atividade de estágio.</small>
            </div>
        </div>

        <div class="row">
            <div class="col-sm form-group">
                <label for="total-semanal"><b>Carga Horária Semanal Total (máximo 30h):</b></label>
                <input type="text" class="form-control" id="total-semanal" value="{{ $estagio->cargahoras !== null ? sprintf('%02d:%02d', $estagio->cargahoras, $estagio->cargaminutos) : '' }}" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-sm form-group">
                <label for="horario">Observações sobre o horário do estágio (casos atípicos, estágio híbrido, escalas alternadas, etc.): </label>
                <textarea class="form-control horario" id="horario" name="horario" rows="3">{{old('horario',$estagio->horario)}}</textarea>
            </div>
        </div>
        <div class="alert alert-danger" role="alert">
            <strong>Atenção:</strong> Algumas Coordenações de Curso exigem intervalo mínimo de 1 hora entre o estágio presencial e as aulas para deslocamento. Casos específicos poderão ser analisados individualmente, inclusive quando as atividades forem realizadas remotamente. O horário estará sujeito à análise da Coordenação do Curso. Em caso de estágio híbrido, informe os dias presenciais e remotos.
        </div>
    </div>
</div>

<hr>

<div class="card">
    <div class="card-header">Auxílio Transporte</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="auxiliotransporte" class="required">Valor do Auxílio transporte (R$): </label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                        <input type="text" class="form-control money" id="auxiliotransporte" name="auxiliotransporte" placeholder="0,00" value="{{old('auxiliotransporte', \App\Models\Estagio::formataMoeda($estagio->auxiliotransporte))}}">
                    </div>
                </div>
            </div>
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="especifiquevt" class="required">Especifique o tipo de vale transporte: </label>               
                    <select name="especifiquevt" class="form-control" id="especifiquevt">
                        <option value="" selected="">- Selecione -</option>
                            @foreach ($estagio->especifiquevtOptions() as $option)
                                @if (old('especifiquevt') == '' and isset($estagio->especifiquevt) )
                                    <option value="{{$option}}" {{ ( $estagio->especifiquevt == $option) ? 'selected' : ''}}>
                                        {{$option}}
                                    </option>
                                @else
                                    <option value="{{$option}}" {{ ( old('especifiquevt') == $option) ? 'selected' : ''}}>
                                        {{$option}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

<hr>

<div class="card">
    <div class="card-header">Informações sobre a empresa</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="nome_de_contato" class="required">Nome de contato da empresa: </label>
                    <input type="text" class="form-control" id="nome_de_contato" name="nome_de_contato" value="{{old('nome_de_contato',$estagio->nome_de_contato)}}">
                </div>
            </div>
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="email_de_contato" class="required">E-mail de contato da empresa: </label>
                    <input type="email" maxlength="128" class="form-control" id="email_de_contato" name="email_de_contato" value="{{old('email_de_contato',$estagio->email_de_contato)}}">
                </div>
            </div>
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="telefone_de_contato" class="required">Telefone de contato da empresa: </label>
                        <input type="text" maxlength="11" class="form-control" id="telefone-com-ddd" name="telefone_de_contato" value="{{old('telefone_de_contato',$estagio->telefone_de_contato)}}">
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="nome_do_supervisor_estagio" class="required">Nome do supervisor do estágio: </label>
                    <input type="text" class="form-control" id="nome_do_supervisor_estagio" name="nome_do_supervisor_estagio" value="{{old('nome_do_supervisor_estagio',$estagio->nome_do_supervisor_estagio)}}">
                </div>
            </div>
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="cargo_do_supervisor_estagio" class="required">Cargo do supervisor de estágio: </label>
                    <input type="text" class="form-control" id="cargo_do_supervisor_estagio" name="cargo_do_supervisor_estagio" value="{{old('cargo_do_supervisor_estagio',$estagio->cargo_do_supervisor_estagio)}}">
                </div>
            </div>    
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="email_do_supervisor_estagio" class="required">E-mail do supervisor de estágio: </label>
                    <input type="email" maxlength="128" class="form-control" id="email_do_supervisor_estagio" name="email_do_supervisor_estagio" value="{{old('email_do_supervisor_estagio',$estagio->email_do_supervisor_estagio)}}">
                </div>
            </div>
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="telefone_do_supervisor_estagio" class="required">Telefone do supervisor de estágio: </label>
                    <input type="text" maxlength="11" class="form-control" id="telefone-com-ddd" name="telefone_do_supervisor_estagio" value="{{old('telefone_do_supervisor_estagio',$estagio->telefone_do_supervisor_estagio)}}">
                </div>
            </div>
        </div>                
    </div>
</div>

<hr>

<div class="card">
    <div class="card-header">Informações sobre seguro</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="seguradora" class="required">Nome da seguradora: </label>
                    <input type="text" class="form-control" id="seguradora" name="seguradora" value="{{old('seguradora',$estagio->seguradora)}}">
                </div>
            </div>
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="numseguro" class="required">Número da apólice de seguro: </label>
                    <input type="text" class="form-control" id="numseguro" name="numseguro" value="{{old('numseguro',$estagio->numseguro)}}">
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
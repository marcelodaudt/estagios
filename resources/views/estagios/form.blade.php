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
                    <label for="horariocompativel" class="required">O horário é compatível com o curso? </label>
                    <input type="text" class="form-control" name="horariocompativel" value="{{old('horariocompativel',$estagio->horariocompativel)}}">
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
                    <input type="text" class="form-control" id="valorbolsa" name="valorbolsa" value="{{old('valorbolsa',$estagio->valorbolsa)}}">
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
                    <input type="text" class="form-control datepicker" id="data_inicial" name="data_inicial" value="{{old('data_inicial',$estagio->data_inicial)}}" onblur="calculodata(this);">
                </div>
            </div>    
            <div class="col-sm form-group">
                <div class="form-group">
                    <label for="data_final" class="required">Data de término do Estágio: </label>
                    <input type="text" class="form-control datepicker" id="data_final" name="data_final" value="{{old('data_final',$estagio->data_final)}}" onblur="calculodata(this);">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="justificativa">Justificativa (Caso o estágio esteja sendo cadastrado em data retroativa, apresente abaixo a justificativa): </label>
            <textarea name="justificativa" rows="5" cols="60">{{old('justificativa',$estagio->justificativa)}}</textarea>
        </div>
    </div>
</div>

<hr>

<div class="card">
    <div class="card-header">Carga Horária</div>
    <div class="card-body">
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
            <small class="form-text text-muted">O Total é calculado automaticamente (Saída menos Entrada, descontado o Tempo de Intervalo). Deixe a linha em branco nos dias sem atividade de estágio. A carga horária semanal (máximo 30h) e diária (máximo 6h) é calculada a partir dos horários informados aqui.</small>
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
            <strong>Atenção:</strong> O horário do estágio deverá ser compatível com o horário escolar do(a) estudante e respeitar o limite máximo de 6 horas diárias e 30 horas semanais, conforme a legislação vigente.
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
                    <input type="text" class="form-control" id="auxiliotransporte" name="auxiliotransporte" value="{{old('auxiliotransporte',$estagio->auxiliotransporte)}}"> 
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
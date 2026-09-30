<div class="card">
  <div class="card-header"><h3>Cadastro de Vaga</h3></div>
  <div class="card-body">

    <div class='alert alert-danger' role='alert'>
      <strong>Ao contratar, sempre verificar os horários das aulas para não apresentar conflito de horário.</strong>
    </div>

    <div class="row">
      <div class="col-sm form-group">
        <label for="titulo" class="required"><strong>Título da Vaga:</strong></label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="{{old('titulo',$vaga->titulo)}}">
      </div>
    </div>

    <div class="row">
      <div class="col-sm form-group">
        <div class="form-group">
          <label for="curso" class="required"><strong>Curso:</strong></label>
          <select name="curso" class="form-control" id="curso">
            <option value="" selected="">- Selecione -</option>
              @foreach ($vaga->cursoOptions() as $option)
                @if (old('curso') == '' and isset($vaga->curso) )
                  <option value="{{$option}}" {{ ( $vaga->curso == $option) ? 'selected' : ''}}>
                    {{$option}}
                  </option>
                @else
                  <option value="{{$option}}" {{ ( old('curso') == $option) ? 'selected' : ''}}>
                    {{$option}}
                  </option>
                @endif
              @endforeach
          </select>
          <span id="curso" style="font-size: 0.8em; color: #666;">Escolha o curso ao qual a vaga é destinada.</span>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm form-group">
        <label for="descricao" class="required"><strong>Descrição da Vaga:</strong></label>
        <textarea class="form-control" id="descricao" name="descricao">{{old('descricao',$vaga->descricao)}}</textarea>
      </div>
      <div class="col-sm form-group">
        <label for="beneficios" class="required"><strong>Benefícios:</strong></label>
        <textarea class="form-control" id="beneficios" name="beneficios">{{old('beneficios',$vaga->beneficios)}}</textarea>
      </div>
      <div class="col-sm form-group">
        <label for="requisitos" class="required"><strong>Requisitos da Vaga:</strong></label>
        <textarea class="form-control" id="requisitos" name="requisitos">{{old('requisitos',$vaga->requisitos)}}</textarea>
        <span id="requisitos" style="font-size: 0.8em; color: #666;">Quais as exigências acadêmicas.</span>
      </div>
    </div>

    <div class="row">
      <div class="col-sm form-group">
        <label for="salario" class="required"><strong>Valor mensal da Bolsa (Somente o Número):</strong></label>
        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
        class="form-control" id="salario" name="salario" width="190" value="{{old('salario',$vaga->salario)}}">
      </div>
      <div class="col-sm form-group">
        <label for="divulgar_ate" class="required"><strong>Divulgar até:</strong></label>
        <input type="text" class="form-control datepicker" id="divulgar_ate" name="divulgar_ate" value="{{old('divulgar_ate',$vaga->divulgar_ate)}}">
      </div>
    </div>

    <div class='alert alert-danger' role='alert'>
      <strong>Informe o horário do estágio (entrada e saída) e o tempo de intervalo. O horário do estágio deverá ser compatível com o horário escolar do(a) estudante e respeitar o limite máximo de 6 horas diárias e 30 horas semanais, conforme a legislação vigente.</strong>
    </div>

    <div class="row">
      <div class="col-sm form-group">
        <label for="hora_entrada" class="required"><strong>Entrada:</strong></label>
        <input type="time" class="form-control" id="hora_entrada" name="hora_entrada" value="{{old('hora_entrada',$vaga->hora_entrada ? substr($vaga->hora_entrada,0,5) : '')}}">
      </div>
      <div class="col-sm form-group">
        <label for="hora_saida" class="required"><strong>Saída:</strong></label>
        <input type="time" class="form-control" id="hora_saida" name="hora_saida" value="{{old('hora_saida',$vaga->hora_saida ? substr($vaga->hora_saida,0,5) : '')}}">
      </div>
      <div class="col-sm form-group">
        <label for="tempo_intervalo" class="required"><strong>Tempo de Intervalo:</strong></label>
        <input type="time" class="form-control" id="tempo_intervalo" name="tempo_intervalo" value="{{old('tempo_intervalo',$vaga->tempo_intervalo ? substr($vaga->tempo_intervalo,0,5) : '')}}">
      </div>
    </div>

    <div class="card">
      <div class="card-header"><strong>Contatos</strong></div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm form-group">
            <label for="contato_email"><strong>E-mail:</strong></label>
            <input type="text" class="form-control" id="contato_email" name="contato_email" value="{{old('contato_email',$vaga->contato_email)}}">
          </div>
        </div>
        <div class="row">
          <div class="col-sm form-group">
            <label for="contato_site"><strong>Website:</strong></label>
            <input type="text" class="form-control" id="contato_site" name="contato_site" value="{{old('contato_site',$vaga->contato_site)}}">
          </div>
        </div>
        <div class="row">
          <div class="col-sm form-group">
            <label for="contato_telefone"><strong>Telefone:</strong></label>
            <input type="text" class="form-control" id="contato_telefone" name="contato_telefone" value="{{old('contato_telefone',$vaga->contato_telefone)}}">
          </div>
        </div>
        <span style="font-size: 0.8em; color: #666;">Envio de Currículos: informar o e-mail ou a página de inscrição (website) para envio do currículo.</span>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-sm form-group">
        <button type="submit" class="btn btn-success">Enviar</button>
      </div>
    </div>

  </div>
</div>
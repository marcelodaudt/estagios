 
<div class="row">
  <div class="col-sm-8 form-group">
      <div class="card-body">
        <label class="card-title required" for="titulo">Título do Aviso: </label>
        <input type="text" class="form-control" id="titulo" name="titulo" value="{{old('titulo',$aviso->titulo)}}">
      </div>
  </div>
  <div class="col-sm-4 form-group"> 
    <div class="card-body">
      <label class="card-title required" for="divulgacao_home_ate">Divulgação Até: </label>
      <input type="text" class="form-control datepicker" id="divulgacao_home_ate" name="divulgacao_home_ate" value="{{old('divulgacao_home_ate',$aviso->divulgacao_home_ate)}}" >
    </div>
  </div>
</div>  
<div class="row">
  <div class="col-sm form-group">
    <div class="card-body">
      <label class="card-title required" for="corpo">Corpo da mensagem: </label>
      <textarea class="form-control" id="corpo" name="corpo" rows="3">{{old('corpo',$aviso->corpo)}}</textarea>
    </div>
  </div>
</div>
</br>
<div class="col-sm form-group">
  <button type="submit" class="btn btn-success">Salvar</button>
  <a class="btn btn-success" href="{{ $app_url }}/avisos" role="button">Voltar</a>
</div>
   
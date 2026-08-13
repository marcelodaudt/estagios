@extends('main') 

@section('content')
@include('flash')

<div class="card">
  <div class="card-header"><h3>Dados da Vaga:<h3></div>

  <div class="card-body">
    @can('owner',$vaga)
      <a href="{{ route('vagas.edit',$vaga->id) }}" class="btn btn-success">Editar</a>
      <br><br>
    @endcan
    
    @can('admin')
      @if($vaga->status != 'Aprovada')
        <form method="POST" action="{{ route('vagas.status',$vaga->id) }}" class="d-inline">
          @csrf
          <input type="hidden" name="status" value="Aprovada">
          <button type="submit" class="btn btn-info"> Aprovar </button>
        </form>
      @endif

      @if($vaga->status != 'Reprovada')
        <form method="POST" action="{{ route('vagas.status',$vaga->id) }}" class="mt-2">
          @csrf
          <input type="hidden" name="status" value="Reprovada">
          <div class="form-group">
            <label for="justificativa"><b>Justificativa da Reprovação:</b></label>
            <textarea name="justificativa" id="justificativa" class="form-control @error('justificativa') is-invalid @enderror" rows="3" required>{{ old('justificativa') }}</textarea>
            @error('justificativa')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <button type="submit" class="btn btn-danger mt-2"> Reprovar </button>
        </form>
      @endif
      <br>
    @endcan

    @can('owner',$vaga)
      @if($vaga->status == 'Reprovada' && $vaga->justificativa)
        <div class="alert alert-danger" role="alert">
          <strong>Motivo da reprovação:</strong> {{ $vaga->justificativa }}
        </div>
      @endif
    @endcan

    <div class='alert alert-danger' role='alert'>
      <strong>Antes de se candidatar a vaga verificar sobre as regras do seu curso sobre o Estágio.</strong>
    </div>
    
    <div class="row">

      <div class="col-sm">
        <b>Título da Vaga:</b> {{ $vaga->titulo }}
        <br></br>
        <b>Curso:</b> {{ $vaga->curso }}
        <br></br>
        <b>Descrição da Vaga:</b> {{ $vaga->descricao }}
        <br></br>
        <b>Requisitos:</b> {{ $vaga->requisitos }}
        <br></br>
        <b>Benefícios:</b> {{ $vaga->beneficios }}
        <br></br>
        <b>Carga Horária Semanal:</b> {{ $vaga->expediente }} Horas
        <br></br>
        <b>Valor mensal da Bolsa:</b> R$ {{ $vaga->salario }}
        <br></br>
        <b>Horário do Estágio:</b> {{ $vaga->horario }}
        <br></br>
        <b>Intervalo:</b> {{ $vaga->intervalo }}
        <br></br>
        <b>Divulgar até:</b> {{ $vaga->divulgar_ate }}
        <br></br>
        <b>Contatos para vaga:</b>
        <br>
        <table style="width: 50%;">
          <tr>
            <td style="width: 5%;">&nbsp;</td>
            <td style="width: 15%;"><b>E-mail:</b></td>
            <td> {{ $vaga->contato_email ?? 'Não informado' }}</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><b>Telefone:</b></td>
            <td> {{ $vaga->contato_telefone ?? 'Não informado' }}</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><b>Website:</b></td>
            <td> {{ $vaga->contato_site ?? 'Não informado' }}</td>
          </tr>
        </table>
      </div>

    </div>

  </div>
</div>

@endsection('content')

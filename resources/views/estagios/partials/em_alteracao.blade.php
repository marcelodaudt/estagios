<div class="card">
    <div class="card-header"><b>Justificativa para alteração</b></div>
        <div class="card-body">

        @can('admin_ou_empresa',$estagio->cnpj)
        <form method="POST" action="{{ $app_url }}/enviar_alteracao/{{$estagio->id}}">
            @csrf
            <div class="row">
                <div class="form-group">
                    <textarea name="alteracao" rows="5" cols="60"></textarea>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-success" name="enviar_analise_tecnica_alteracao" value="enviar_analise_tecnica_alteracao" 
                onClick="return confirm('Tem certeza que deseja enviar a alteração?')">Enviar aditivo de alteração para análise</button>
            </div>

        </form>
        @endcan

    </div>
</div>

<br>

<div class="card">
    <div class="card-header"><b>Voltar Estágio</b></div>
    <div class="card-body">
        <a class="btn btn-info" onClick="return confirm('Tem certeza que deseja retornar o estágio para a etapa anterior?')" href="{{ $app_url }}/voltar_aditivo/{{$estagio->id}}">
        <i class="fas fa-undo"></i> 
        Retornar estágio para concluído</a> <br>
    </div>
</div>

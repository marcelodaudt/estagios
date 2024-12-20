@can('admin_ou_empresa',$estagio->cnpj)

<div class="row">
    <div class="col-4 form-group">

        Enviar documentos (Apenas arquivos em formato PDF):

        <form method="post" enctype="multipart/form-data" action="{{ $app_url }}/files/store">
            @csrf 
            <input type="hidden" name="estagio_id" value="{{ $estagio->id }}">
            <input type="file" name="file">
            <br><hr>
            <label for="original_name" class="required">Nome do Arquivo: </label>
            <input type="text" class="form-control" id="original_name" name="original_name">
            <br>
            <label for="tipoarquivo" class="required">Tipo de Arquivo: </label>
            <select name="tipoarquivo" class="form-control" id="tipoarquivo">
                <option value="" selected="">- Selecione -</option>
                <option value="documento">Documento Anexo</option>
                <option value="relatorioparcial">Relatório</option>
            </select> 
            <br>
            <button type="submit" class="btn btn-success"> Enviar </button>
        </form>   

    </div>
    <div class="col-8 form-group">

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Arquivo</th>
                    <th>Parecer de Relatório</th>
                    @can('admin')
                    <th>Ações</th>
                    @endcan('admin')
                </tr>
                </thead>
                <tbody>
                @foreach($estagio->arquivos as $arquivo)
                @if($arquivo->tipo_documento != 'Relatorio')
                    <tr>
                    <td>
                    @if($arquivo->tipo_documento == 'relatorioparcial' || $arquivo->tipo_documento == 'relatorioparcial_ciente')
                        <a href="{{ $app_url }}/files/{{$arquivo->id}}.pdf" type="application/pdf" target="pdf-frame"><i class="fas fa-file-pdf"></i> (Relatório) {{$arquivo->original_name}} </a>
                    @else            
                        <a href="{{ $app_url }}/files/{{$arquivo->id}}.pdf"  type="application/pdf" target="pdf-frame"><i class="fas fa-file-pdf"></i> {{$arquivo->original_name}} </a>
                    @endif
                    </td>

                    <td>
                        @if($arquivo->tipo_documento == 'relatorioparcial')
                            O parecerista ainda não confirmou ciência do relatório
                        @elseif ($arquivo->tipo_documento == 'relatorioparcial_ciente')
                            O parecerista está ciente do relatório
                        @endif            
                    </td>

                    @can('admin')
                        <td>
                            <form method="post" action="{{ $app_url }}/files/{{$arquivo->id}}">         
                                @csrf
                                @method('delete')
                                <button class="botao" type="submit" onclick="return confirm('Tem certeza que deseja deletar?');"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            <div>
                        </td>
                    @endcan('admin')

                    </tr>
                @endif    
                @endforeach
                </tbody>
            </table>

    </div>

</div>
<hr>
@endcan


@can('parecerista')

<div class="row">

<table class="table table-striped">
    <thead>
        <tr>
            <th>Arquivo</th>
            <th>Parecer de Relatório</th>
        </tr>
    </thead>
    @foreach($estagio->arquivos as $arquivo)
        <tr>
        <td>
            @if($arquivo->tipo_documento == 'relatorioparcial' || $arquivo->tipo_documento == 'relatorioparcial_ciente')
                <a href="{{ $app_url }}/files/{{$arquivo->id}}.pdf" type="application/pdf" target="pdf-frame"><i class="fas fa-file-pdf"></i> (Relatório) {{$arquivo->original_name}}</a>
            @else            
                <a href="{{ $app_url }}/files/{{$arquivo->id}}.pdf" type="application/pdf" target="pdf-frame"><i class="fas fa-file-pdf"></i> {{$arquivo->original_name}} </a>
            @endif            
        </td>
        <td>
            @if($arquivo->tipo_documento == 'relatorioparcial')
                <a onClick="return confirm('Tem certeza que deseja confirmar ciência do relatório?')" href="{{ $app_url }}/files/ciente_relatorio/{{$arquivo->id}}"> 
                <i class="fas fa-check"></i> Clique aqui para confirmar ciência do relatório </a>
            @elseif ($arquivo->tipo_documento == 'relatorioparcial_ciente')
                Você marcou que está ciente deste relatório
            @endif            
        </td>
        </tr>
    @endforeach
</table>

</div>

@endcan
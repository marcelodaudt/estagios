
Aviso de que o pedido de aditivo de alteração no estágio de {{ $estagio->nome }}, Nº USP {{ $estagio->numero_usp }}, foi 
indeferido pela Seção de Estágios da ECA - USP
<br><br>

@foreach($estagio->aditivos->where('aprovado_graduacao','=',0)->where('comentario_graduacao','!=',null) as $aditivo)
@if($loop->last)

Aditivo que havia sido requisitado: <b>{{ $aditivo->alteracao }}</b><br><br>

Comentário da Seção de Estágios: <b>{{ $aditivo->comentario_graduacao }}</b><br><br>

@if(($aditivo->comentario_parecerista)!=null)
Análise do Parecerista sobre o Aditivo: <b>{{ $aditivo->comentario_parecerista }}</b><br><br>
@endif

@endif
@endforeach

<br><br>
Favor entrar em contato com a Seção de Estágios da ECA em caso de duvidas sobre a ação.
<br><br>
Mensagem automática, não responder - Sistema de Estágios - ECA-USP



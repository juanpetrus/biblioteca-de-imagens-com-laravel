<div class="row">
  @foreach($lista as $key => $value)
    <div class="col s12 m{{$tamanho}}">
      @component('componentes.cartao',[
        'carro'=>$value,
        'titulo'=>$value->titulo,
        'descricao'=>$value->descricao,
        'imagem'=>$value->imagens()->where('deletado','=','N')->orderBy('ordem')->first()->imagem->galeriaUrl(),
        'valor'=>$value->textoValor,
        'url'=>route('site.detalhe',[$value->id,str_slug($value->titulo)])]
        )

      @endcomponent
    </div>
  @endforeach

</div>

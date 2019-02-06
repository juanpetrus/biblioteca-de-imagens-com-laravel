@extends('layouts.app')

@section('content')

<div class="container">
    <div id="destaques" class="row section scrollspy">
      <div class="col s12 m6">
        @component('componentes.slide',['lista'=>$carro->imagens()->where('deletado','=','N')->get()])
        @endcomponent
      </div>

      <div class="col s12 m6">
        <div class="card">
          <div class="card-stacked">
            <div class="card-content">
              <h5 class="header">{{$carro->titulo}} - {{$carro->marca->titulo}}</h5>
              <p>{{$carro->descricao}}</p>
              <p>Ano: {{$carro->ano}}</p>
              <p>Categorias: {{$carro->textoCategorias}}</p>
              <p>Preço: {{$carro->textoValor}}</p>
            </div>
          </div>
        </div>
        <h3 class="center">Contato:</h3>
        <form>
          <div class="input-field col s12">
            <input type="text" class="validate">
            <label>Nome</label>
          </div>
          <div class="input-field col s12">
            <input type="email" class="validate">
            <label>E-mail</label>
          </div>
          <div class="input-field col s12">
            <textarea class="materialize-textarea"></textarea>
            <label>Mensagem</label>
          </div>
          <div class="input-field col s12">
            <button  class="waves-effect waves-light btn">Enviar</button>
          </div>
        </form>
      </div>

    </div>
</div>
@endsection

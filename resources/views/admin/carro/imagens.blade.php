@extends('layouts.app')

@section('content')

<div class="container">

  <h2 class="center">Selecionar imagens</h2>
  @include('admin._caminho')
  <div class="row">

  <?php $conta = 0; ?>
  @foreach($imagens as $imagem)
    <?php $imagem->selecionado = false; ?>
    @if($imagensCarro)
      @foreach($imagensCarro as $value)
        @if($value->imagem_id == $imagem->id)
          <?php $imagem->selecionado = true; ?>
        @endif
      @endforeach
    @endif

       <div class="col s12 m4">
         <div class="card">
           <div class="card-image">
             <img class="materialboxed" src="{{$imagem->pequenaUrl()}}">

           </div>
           <div class="card-content">
             <strong>{{$imagem->titulo}}</strong>
           </div>
           <div class="card-action" id="divID{{$imagem->id}}">
             @if($imagem->selecionado)
               <a onclick="removeImagem({{$imagem->id}},'divID{{$imagem->id}}')" class="btn green">Remover imagem</a>
             @else
                <a onclick="selecionaImagem({{$imagem->id}},'divID{{$imagem->id}}')" class="btn blue">Selecionar imagem</a>
             @endif

           </div>
         </div>
       </div>

       <?php $conta++; ?>
       @if($conta == 3)
         <?php $conta=0; ?>
         </div>
         <div class="row">
       @endif

  @endforeach
  </div>

  <div align="center" class="row">
    {{ $imagens->links() }}
  </div>

  <div class="row">
    @can('carros-view')
    <a class="btn blue" href="{{route('carros.galeria.index',$carro)}}">Voltar</a>
    @endcan

  </div>

  <script type="text/javascript">

    function selecionaImagem(id,divID){
      $('#'+divID).html('<button class="btn orange">Processando..</button>');
      $.ajax({
          headers: {
              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          url: "{{route('carros.galeria.store')}}",
          data: 'id='+id+'&carro={{$carro->id}}',
          success: function(data){
              console.log(data);
              $('#'+divID).html('<button onclick="removeImagem('+id+',\''+divID+'\')" class="btn green">Remover imagem</button>');
          },
          error: function(){
              $('#'+divID).html('<a onclick="selecionaImagem('+id+',\''+divID+'\')" class="btn blue">Selecionar imagem</a>');
          }
      });
    }
    function removeImagem(id,divID){
        $('#'+divID).html('<button class="btn orange">Processando..</button>');
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE',
            url: "{{route('carros.galeria.remove')}}",
            data: 'id='+id+'&carro={{$carro->id}}',
            success: function(data){
                console.log(data);
                $('#'+divID).html('<a onclick="selecionaImagem('+id+',\''+divID+'\')" class="btn blue">Selecionar imagem</a>');
            },
            error: function(){
                $('#'+divID).html('<button onclick="removeImagem('+id+',\''+divID+'\')" class="btn green">Remover imagem</button>');
            }
        });
    }

  </script>


</div>
@endsection

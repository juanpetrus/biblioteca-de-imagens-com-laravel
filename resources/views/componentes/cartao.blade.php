<div class="card">
  <div class="card-image">
    <img class="materialboxed" src="{{$imagem}}">
  </div>
  <div class="card-stacked">
    <div class="card-content">
      <h5 class="header">{{$titulo}}</h5>
      <p>{{$descricao}}</p>
      <strong>{{$valor}}</strong>
    </div>
    <div class="card-action">

      @can('favoritos-view')
        @if(Auth()->user()->carros()->find($carro->id))
          <form action="{{route('site.favoritos.delete',$carro)}}" method="post">
            <a href="{{$url}}">Ver mais</a>
            @can('favoritos-delete')
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button title="Remover dos Favoritos" class="btn yellow"><i class="material-icons">stars</i></button>
            @endcan
          </form>

        @else
          <form action="{{route('site.favoritos.create',$carro)}}" method="post">
            <a href="{{$url}}">Ver mais</a>
            @can('favoritos-create')
              {{ csrf_field() }}
              <button title="Adicionar dos Favoritos" class="btn green"><i class="material-icons">star</i></button>
            @endcan
          </form>
        @endif

      @else
        <a href="{{$url}}">Ver mais</a>
      @endcan

    </div>
  </div>
</div>

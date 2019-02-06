<div class="slider ">
  <ul class="slides">
    @foreach($lista as $key => $value)
      <li>
        <img src="{{$value->url}}"> <!-- random image -->
        <div class="caption center-align">
          @if(isset($value->titulo))
            <h3>{{$value->titulo}}</h3>
          @endif
          @if(isset($value->descricao))
            <h5 class="light grey-text text-lighten-3">{{$value->descricao}}</h5>
          @endif

          @if(isset($value->link) && $value->link != '')
            <a class="btn {{config('app.corSite')}}" href="{{$value->link}}">Ver mais</a>
          @endif

        </div>
      </li>
    @endforeach
  </ul>
</div>

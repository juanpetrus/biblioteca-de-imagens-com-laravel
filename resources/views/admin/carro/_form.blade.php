<div class="input-field">
	<input type="text" name="titulo" class="validade" value="{{ isset($registro->titulo) && !old('titulo') ? $registro->titulo : '' }}{{old('titulo')}}">
	<label>Nome</label>
</div>

<div class="input-field">
	<input type="text" name="descricao" class="validade" value="{{ isset($registro->descricao) && !old('descricao') ? $registro->descricao : '' }}{{old('descricao')}}">
	<label>Descrição</label>
</div>

<div class="input-field">
	<input type="text" name="ano" class="validade" value="{{ isset($registro->ano) && !old('ano') ? $registro->ano : '' }}{{old('ano')}}">
	<label>Ano</label>
</div>

<div class="input-field">
	<input type="text" name="valor" class="validade" value="{{ isset($registro->valor) && !old('valor') ? $registro->valor : '' }}{{old('valor')}}">
	<label>Valor</label>
</div>

<div class="input-field col s6">
    <select name="marca_id">
      @foreach($marcas as $key => $value)
        <option {{ (isset($registro->marca_id) && $registro->marca_id ==  $value->id) || old('marca_id') ==  $value->id ? 'selected' : '' }} value="{{$value->id}}">{{$value->titulo}}</option>
      @endforeach

    </select>
    <label>Marca</label>
</div>

<div class="input-field col s6">
    <select multiple name="novasCategorias[]">
      @if(isset($registro->categorias) && $registro->categorias()->count() && !old('novasCategorias'))
        @foreach($categorias as $key => $value)
          <option {{ $registro->categorias->contains($value) ? 'selected' : '' }}  value="{{$value->id}}">{{$value->titulo}}</option>
        @endforeach
      @elseif(old('novasCategorias'))
        @foreach($categorias as $key => $value)
          <?php $existe = false; ?>
          @foreach(old('novasCategorias') as $key2 => $value2)
            @if($value2 == $value->id)
              <?php $existe = true; ?>
            @endif
          @endforeach
          @if($existe)
            <option selected  value="{{$value->id}}">{{$value->titulo}}</option>
          @else
            <option  value="{{$value->id}}">{{$value->titulo}}</option>
          @endif
        @endforeach
      @else
        <option value="" disabled selected>Nenhuma</option>
        @foreach($categorias as $key => $value)
          <option  value="{{$value->id}}">{{$value->titulo}}</option>
        @endforeach
      @endif
    </select>
    <label>Categorias</label>
  </div>

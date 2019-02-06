@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="center">Editar Slide</h2>
	@if (count($errors) > 0)
		<div class="row">
        <div class="col s12">
          <div class="card red darken-1">
            <div class="card-content white-text">
              <span class="card-title">Erros</span>
							@foreach ($errors->all() as $message)
					        <li>{{$message}}</li>
					    @endforeach
            </div>
          </div>
        </div>
      </div>
  @endif
	@include('admin._caminho')
	<div class="row">
		<form action="{{ route('slides.update',$registro) }}" method="post">

		{{csrf_field()}}
		{{ method_field('PUT') }}

		<div class="input-field">
			<input type="text" name="titulo" class="validade" value="{{ isset($registro->titulo) ? $registro->titulo : '' }}{{old('titulo')}}">
			<label>Título</label>
		</div>

		<div class="input-field">
			<input type="text" name="descricao" class="validade" value="{{ isset($registro->descricao) ? $registro->descricao : '' }}{{old('descricao')}}">
			<label>Descrição</label>
		</div>

		<div class="input-field">
			<input type="text" name="link" class="validade" value="{{ isset($registro->link) ? $registro->link : '' }}{{old('descricao')}}">
			<label>Link</label>
		</div>

		<div class="input-field">
			<input type="text" name="ordem" class="validade" value="{{ isset($registro->ordem) ? $registro->ordem : '' }}{{old('ordem')}}">
			<label>Ordem</label>
		</div>

		<button class="btn blue">Atualizar</button>


		</form>

	</div>

</div>


@endsection

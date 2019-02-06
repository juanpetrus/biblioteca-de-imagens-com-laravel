@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="center">Editar Imagem</h2>
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
		<form action="{{ route('imagens.update',$registro->id) }}" method="post" enctype="multipart/form-data">

		{{csrf_field()}}
		{{ method_field('PUT') }}
		<div class="input-field">
			<input type="text" name="titulo" class="validade" value="{{ isset($registro->titulo) ? $registro->titulo : '' }}">
			<label>Título</label>
		</div>

		<div class="input-field">
			<input type="text" name="descricao" class="validade" value="{{ isset($registro->descricao) ? $registro->descricao : '' }}">
			<label>Descrição</label>
		</div>
		<div class="file-field input-field">
		  <div class="btn">
		    <span>Atualizar imagem</span>
		    <input type="file" name="imagem">
		  </div>
		  <div class="file-path-wrapper">
		    <input class="file-path validate" type="text">
		  </div>
		</div>

		<button class="btn blue">Atualizar</button>

		<h3>Tamanhos gerados</h3>

		<div class="row">
			 <div class="col s12 m3">
				 <div class="card">
					 <div class="card-image">
						 <img class="materialboxed" src="{{$registro->pequenaUrl()}}">

					 </div>
					 <div class="card-content">
						 <strong>Pequena</strong>
						 <p>{{config('app.imagemPequena')}}</p>
					 </div>
				 </div>
			 </div>
			 <div class="col s12 m4">
				 <div class="card">
					 <div class="card-image">
						 <img class="materialboxed" src="{{$registro->galeriaUrl()}}">

					 </div>
					 <div class="card-content">
						 <strong>Galeria</strong>
						 <p>{{config('app.imagemGaleria')}}</p>
					 </div>
				 </div>
			 </div>
			 <div class="col s12 m5">
				 <div class="card">
					 <div class="card-image">
						 <img class="materialboxed" src="{{$registro->slideUrl()}}">

					 </div>
					 <div class="card-content">
						 <strong>Slide</strong>
						 <p>{{config('app.imagemSlide')}}</p>
					 </div>
				 </div>
			 </div>
		 </div>

		</form>

	</div>

</div>


@endsection

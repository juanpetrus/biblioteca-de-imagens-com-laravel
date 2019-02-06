@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="center">Editar Perfil</h2>
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

	@if (session('status'))
		<div class="row">
        <div class="col s12">
          <div class="card green darken-1">
            <div class="card-content white-text">
              <span class="card-title">Status</span>
							<p>{{session('status')}}</p>
            </div>
          </div>
        </div>
      </div>
  @endif

	@include('admin._caminho')
	<div class="row">
		<form action="{{ route('site.perfil.update') }}" method="post">

		{{csrf_field()}}
		{{ method_field('PUT') }}
		<div class="input-field">
			<input type="text" name="name" class="validade" value="{{ isset($user->name) && !old('name') ? $user->name : '' }}{{old('name')}}">
			<label>Nome</label>
		</div>

		<div class="input-field">
			<input type="email" name="email" class="validade" value="{{ isset($user->email) && !old('email') ? $user->email : '' }}{{old('email')}}">
			<label>E-mail</label>
		</div>

		<div class="input-field">
			<input type="password" name="password" class="validade" >
			<label>Senha</label>
		</div>

		<div class="input-field">
			<input type="password" name="password_confirmation" class="validade" >
			<label>Confirme a senha</label>
		</div>

		<button class="btn blue">Atualizar</button>

		</form>

	</div>

</div>


@endsection

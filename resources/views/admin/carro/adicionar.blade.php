@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="center">Adicionar Carro</h2>

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
		<form action="{{ route('carros.store') }}" method="post">

		{{csrf_field()}}
		@include('admin.carro._form')

		<button class="btn green">Adicionar</button>


		</form>

	</div>

</div>


@endsection

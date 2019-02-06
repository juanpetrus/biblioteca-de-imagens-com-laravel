@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="center">Lista de Favoritos</h2>


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
  @component('componentes.lista_cartao',['lista'=>$carros,'tamanho'=>'4'])
  @endcomponent

</div>


@endsection

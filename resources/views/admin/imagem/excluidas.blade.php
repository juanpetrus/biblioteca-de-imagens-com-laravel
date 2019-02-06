@extends('layouts.app')

@section('content')
	<div class="container">
		<h2 class="center">Lista de Imagens Excluídas</h2>

		@include('admin._caminho')
		<div class="row">
			<table>
				<thead>
					<tr>
						<th>Id</th>
						<th>Título</th>
						<th>Descrição</th>
						<th>Imagem</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($registros as $registro)
					<tr>
						<td>{{ $registro->id }}</td>
						<td>{{ $registro->titulo }}</td>
						<td>{{ $registro->descricao }}</td>
						<td><img width="50" class="materialboxed" src="{{$registro->galeriaUrl()}}" alt="{{$registro->titulo}}"></td>

						<td>


							<form action="{{route('imagens.recupera',$registro->id)}}" method="post">

								@can('imagens-delete')
									{{ method_field('PUT') }}
									{{ csrf_field() }}
									<button title="Recuperar" class="btn green"><i class="material-icons">restore</i></button>
								@endcan
							</form>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>

		</div>
		<div class="row">
			@can('imagens-create')
			<a class="btn blue" href="{{route('imagens.index')}}">Voltar</a>
			@endcan

		</div>

		<div align="center" class="row">
			{{ $registros->links() }}
		</div>
	</div>

@endsection

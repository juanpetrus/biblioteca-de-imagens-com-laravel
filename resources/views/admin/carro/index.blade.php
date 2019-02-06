@extends('layouts.app')

@section('content')
	<div class="container">
		<h2 class="center">Lista de Carros</h2>

		@include('admin._caminho')
		<div class="row">
			<table>
				<thead>
					<tr>
						<th>Id</th>
						<th>Título</th>
						<th>Descrição</th>
						<th>Ano</th>
						<th>Marca</th>
						<th>Categoria</th>
						<th>Preço</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($registros as $registro)
					<tr>
						<td>{{ $registro->id }}</td>
						<td>{{ $registro->titulo }}</td>
						<td>{{ $registro->descricao }}</td>
						<td>{{ $registro->ano }}</td>
						<td>{{ $registro->marca->titulo }}</td>
						<td>{{ $registro->textoCategorias }}</td>


						<td>{{ $registro->textoValor }}</td>


						<td>

							<form action="{{route('carros.destroy',$registro)}}" method="post">
								@can('carros-edit')
								<a title="Editar" class="btn orange" href="{{ route('carros.edit',$registro) }}"><i class="material-icons">mode_edit</i></a>
								<a title="Galeria" class="btn blue" href="{{ route('carros.galeria.index',$registro) }}"><i class="material-icons">image</i></a>

								@endcan
								@can('carros-delete')
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<button title="Deletar" class="btn red"><i class="material-icons">delete</i></button>
								@endcan
							</form>

						</td>
					</tr>
				@endforeach
				</tbody>
			</table>

		</div>
		<div class="row">
			@can('carros-create')
			<a class="btn blue" href="{{route('carros.create')}}">Adicionar</a>
			@endcan
		</div>

		<div align="center" class="row">
			{{ $registros->links() }}
		</div>

	</div>

@endsection

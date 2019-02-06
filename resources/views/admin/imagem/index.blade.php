@extends('layouts.app')

@section('content')
	<div class="container">
		<h2 class="center">Lista de Imagens</h2>

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


							<form action="{{route('imagens.destroy',$registro->id)}}" method="post">
								@can('imagens-edit')
								<a title="Editar" class="btn orange" href="{{ route('imagens.edit',$registro->id) }}"><i class="material-icons">mode_edit</i></a>

								@endcan
								@can('imagens-delete')
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
			@can('imagens-create')
			<a class="btn blue" href="{{route('imagens.create')}}">Adicionar</a>
			@endcan

			@can('imagens-edit')
			<a class="btn red" href="{{route('imagens.excluidas')}}">Excluídas</a>
			@endcan
		</div>

		<div align="center" class="row">
			{{ $registros->links() }}
		</div>
	</div>

@endsection

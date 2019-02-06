@extends('layouts.app')

@section('content')
	<div class="container">
		<h2 class="center">Lista de Slides</h2>

		@include('admin._caminho')
		<div class="row">
			<table>
				<thead>
					<tr>
						<th>Imagem</th>
						<th>Título</th>
						<th>Descrição</th>
						<th>Link</th>
						<th>Ordem</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($registros as $registro)
					<tr>
            <td><img width="50" class="materialboxed" src="{{ $registro->url }}"></td>

						<td>{{ $registro->titulo ? $registro->titulo : '---' }}</td>
						<td>{{ $registro->descricao ? $registro->descricao : '---' }}</td>
						<td>{{ $registro->link ? $registro->link : '---' }}</td>
						<td>{{ $registro->ordem }}</td>


						<td>

              <form action="{{route('slides.destroy',$registro)}}" method="post">
								@can('slides-edit')
								<a title="Editar" class="btn orange" href="{{route('slides.edit',$registro)}}"><i class="material-icons">mode_edit</i></a>

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
			@can('slides-create')
			<a class="btn blue" href="{{route('slides.create')}}">Adicionar</a>
			@endcan
		</div>

		<div align="center" class="row">
			{{ $registros->links() }}
		</div>

	</div>

@endsection

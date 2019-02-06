@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row center">
      <h2>Admin</h2>
    </div>

    @include('admin._caminho')

    <div class="row">
      @can('carros-view')
        <div class="col s12 m6">
          <div class="card orange darken-2">
            <div class="card-content white-text">
              <span class="card-title">Carros</span>
              <p>Lista de Carros</p>
            </div>
            <div class="card-action">
              <a href="{{route('carros.index')}}">Visualizar</a>
            </div>
          </div>
        </div>
      @endcan
      @can('imagens-view')
        <div class="col s12 m6">
          <div class="card red darken-2">
            <div class="card-content white-text">
              <span class="card-title">Imagens</span>
              <p>Lista de Imagens</p>
            </div>
            <div class="card-action">
              <a href="{{route('imagens.index')}}">Visualizar</a>
            </div>
          </div>
        </div>
      @endcan
      @can('usuario-view')
        <div class="col s12 m6">
          <div class="card purple darken-2">
            <div class="card-content white-text">
              <span class="card-title">Usuários</span>
              <p>Usuários do sistema</p>
            </div>
            <div class="card-action">
              <a href="{{route('usuarios.index')}}">Visualizar</a>
            </div>
          </div>
        </div>
      @endcan
      @can('slides-view')
        <div class="col s12 m6">
          <div class="card yellow darken-2">
            <div class="card-content white-text">
              <span class="card-title">Slides</span>
              <p>Lista de Slides</p>
            </div>
            <div class="card-action">
              <a href="{{route('slides.index')}}">Visualizar</a>
            </div>
          </div>
        </div>
      @endcan
      @can('favoritos-view')
        <div class="col s12 m6">
          <div class="card blue">
            <div class="card-content white-text">
              <span class="card-title">Favoritos</span>
              <p>Lista de carros favoritos</p>
            </div>
            <div class="card-action">
              <a href="{{route('site.favoritos')}}">Visualizar</a>
            </div>
          </div>
        </div>
      @endcan
      @can('perfil-view')
        <div class="col s12 m6">
          <div class="card green">
            <div class="card-content white-text">
              <span class="card-title">Perfil</span>
              <p>Alterar dados do perfil</p>
            </div>
            <div class="card-action">
              <a href="{{route('site.perfil')}}">Visualizar</a>
            </div>
          </div>
        </div>
      @endcan
      @can('papel-view')
        <div class="col s12 m6">
          <div class="card orange darken-4">
            <div class="card-content white-text">
              <span class="card-title">Papéis</span>
              <p>Listar papéis do sistema</p>
            </div>
            <div class="card-action">
              <a href="{{route('papeis.index')}}">Visualizar</a>
            </div>
          </div>
        </div>
        @endcan
      </div>


</div>
@endsection

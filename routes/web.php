<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("teste1","testeImagemController@teste1");
Route::post("teste1","testeImagemController@teste1Post");

Route::get("teste2","testeImagemController@teste2");
Route::post("teste2","testeImagemController@teste2Post");

Route::get('/addregistros', function () {

  $zero  = App\Categoria::create(['titulo'=>'Zero KM']);
  $semi  = App\Categoria::create(['titulo'=>'Seminovos']);
  $usado = App\Categoria::create(['titulo'=>'Usados']);

  $Honda = App\Marca::create(['titulo'=>'Honda','descricao'=>'Carros Honda']);
  $Chevrolet = App\Marca::create(['titulo'=>'Chevrolet','descricao'=>'Carros Chevrolet']);

  $Camaro = $Chevrolet->carros()->create(['titulo'=>'Camaro','descricao'=>'Automático e completo','ano'=>2017,'valor'=>150000.90]);
  $Civic = App\Carro::create(['marca_id'=>1,'titulo'=>'Civic','descricao'=>'Automático e completo','ano'=>2017,'valor'=>80000.00]);

  $Camaro->categorias()->attach($usado);
  $Camaro->categorias()->attach($semi);

  $categorias = [
      new App\Categoria(['titulo'=>'Nacional']),
      new App\Categoria(['titulo'=>'Destaque']),
      new App\Categoria(['titulo'=>'Luxo'])
  ];

  $Civic->categorias()->saveMany($categorias);
  $Civic->categorias()->attach($semi);

  $usuario = App\User::find(1);

  $usuario->carros()->attach($Civic);
  $usuario->carros()->attach($Camaro);

  return "Registros criados";

});

Route::get('/testesregistros', function () {

  $carro = App\Carro::find(1);
  //dd($carro->marca);

  $marca = App\Marca::find(1);

  //dd($marca->carros);

  //dd($carro->categorias);

  $categoria = App\Categoria::find(2);

  //dd($categoria->carros);

  //dd($carro->usuarios);

  $usuario = App\User::find(1);
  //dd($usuario->carros);

  dd($carro->imagens);


});

Route::get('/addgalerias', function () {

  for($i=1; $i<4;$i++){
    App\Galeria::create([
      'titulo'=> '',
      'carro_id'=> 1,
      'descricao'=> '',
      'url'=> 'http://o.aolcdn.com/commerce/autodata/images/USC60CHC021A021001.jpg',
      'ordem'=> $i
    ]);
    App\Galeria::create([
      'titulo'=> '',
      'carro_id'=> 2,
      'descricao'=> '',
      'url'=> 'http://o.aolcdn.com/commerce/autodata/images/USC60CHC021A021001.jpg',
      'ordem'=> $i
    ]);
  }

  return "Registros criados";


});

Route::get('/', ['as'=>'site.home','uses'=>'Site\SiteController@home']);
Route::get('/carro/{id}/{titulo?}', ['as'=>'site.detalhe','uses'=>'Site\SiteController@detalhe']);

Auth::routes();

Route::get('/contato',function(){
  $galeria = [
    (object)[
      'url'=>'http://st.automobilemag.com/uploads/sites/11/2016/02/2017-Chevrolet-Camaro-1LE-homepage.jpg'
    ]
  ];
  return view('site.contato',compact('galeria'));
});
Route::get('/detalhe',function(){
  $galeria = [
    (object)[
      'url'=>'http://st.automobilemag.com/uploads/sites/11/2016/02/2017-Chevrolet-Camaro-1LE-homepage.jpg'
    ]
  ];
  return view('site.detalhe',compact('galeria'));
});
Route::get('/empresa',function(){
  $galeria = [
    (object)[
      'url'=>'http://st.automobilemag.com/uploads/sites/11/2016/02/2017-Chevrolet-Camaro-1LE-homepage.jpg'
    ]
  ];
  return view('site.empresa',compact('galeria'));
});



Route::group(['middleware' => 'auth','prefix' => 'admin'], function () {

  Route::get('/', 'Admin\AdminController@index');
  Route::resource('usuarios', 'Admin\UsuarioController');

  Route::get('usuarios/papel/{id}', ['as'=>'usuarios.papel','uses'=>'Admin\UsuarioController@papel']);
  Route::post('usuarios/papel/{papel}', ['as'=>'usuarios.papel.store','uses'=>'Admin\UsuarioController@papelStore']);
  Route::delete('usuarios/papel/{usuario}/{papel}', ['as'=>'usuarios.papel.destroy','uses'=>'Admin\UsuarioController@papelDestroy']);

  Route::resource('papeis', 'Admin\PapelController');

  Route::get('papeis/permissao/{id}', ['as'=>'papeis.permissao','uses'=>'Admin\PapelController@permissao']);
  Route::post('papeis/permissao/{permissao}', ['as'=>'papeis.permissao.store','uses'=>'Admin\PapelController@permissaoStore']);
  Route::delete('papeis/permissao/{papel}/{permissao}', ['as'=>'papeis.permissao.destroy','uses'=>'Admin\PapelController@permissaoDestroy']);

  Route::get('imagens/excluidas', ['as'=>'imagens.excluidas','uses'=>'Admin\ImagemController@excluidas']);
  Route::put('imagens/recupera/{id}', ['as'=>'imagens.recupera','uses'=>'Admin\ImagemController@recupera']);

  Route::resource('imagens', 'Admin\ImagemController');

  Route::get('carros/galeria/{carro}', ['as'=>'carros.galeria.index','uses'=>'Admin\CarroController@indexGaleria']);
  Route::get('carros/galeria/create/{carro}', ['as'=>'carros.galeria.create','uses'=>'Admin\CarroController@createGaleria']);
  Route::post('carros/galeria/store', ['as'=>'carros.galeria.store','uses'=>'Admin\CarroController@storeGaleria']);
  Route::delete('carros/galeria/remove', ['as'=>'carros.galeria.remove','uses'=>'Admin\CarroController@removeGaleria']);

  Route::get('carros/galeria/edit/{galeria}', ['as'=>'carros.galeria.edit','uses'=>'Admin\CarroController@editGaleria']);
  Route::put('carros/galeria/update/{galeria}', ['as'=>'carros.galeria.update','uses'=>'Admin\CarroController@updateGaleria']);
  Route::delete('carros/galeria/delete/{galeria}', ['as'=>'carros.galeria.delete','uses'=>'Admin\CarroController@deleteGaleria']);

  Route::resource('carros', 'Admin\CarroController');


  Route::post('slides/store/ajax', ['as'=>'slides.store.ajax','uses'=>'Admin\SlideController@storeSlide']);
  Route::delete('slides/remove/ajax', ['as'=>'slides.remove.ajax','uses'=>'Admin\SlideController@removeSlide']);

  Route::resource('slides', 'Admin\SlideController');

  Route::get('perfil', ['as'=>'site.perfil','uses'=>'Site\SiteController@perfil']);
  Route::put('perfil', ['as'=>'site.perfil.update','uses'=>'Site\SiteController@perfilUpdate']);

  Route::get('favoritos', ['as'=>'site.favoritos','uses'=>'Site\SiteController@favoritos']);

  Route::post('favoritos/{carro}', ['as'=>'site.favoritos.create','uses'=>'Site\SiteController@favoritosCreate']);
  Route::delete('favoritos/{carro}', ['as'=>'site.favoritos.delete','uses'=>'Site\SiteController@favoritosDelete']);
});

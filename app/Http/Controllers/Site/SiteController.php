<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Gate;

use App\Carro;
use App\Slide;

class SiteController extends Controller
{
    public function home()
    {
        $slides = Slide::where('deletado','=','N')->orderBy('ordem')->get();

        $carros = Carro::all();


      return view('site.home',compact('slides','carros'));
    }
    public function detalhe($id,$titulo = null)
    {
      $carro = Carro::find($id);

      if(str_slug($carro->titulo) == $titulo){
        return view('site.detalhe',compact('carro'));
      }else{
        return redirect()->route('site.home');
      }

    }

    public function perfil()
    {
      if(Gate::denies('perfil-view')){
        abort(403,"Não autorizado!");
      }
      $user = Auth()->user();

      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>'','titulo'=>'Editar Perfil']
      ];

      return view('site.perfil',compact('user','caminhos'));

    }

    public function perfilUpdate(Request $request)
    {
      if(Gate::denies('perfil-edit')){
        abort(403,"Não autorizado!");
      }
      $user = Auth()->user();

      $this->validate($request,[
        'name'=>'required',
        'email'=>'required|email|unique:users,email,'.$user->id
      ]);

      $dados = $request->all();

      if(isset($dados['password']) && $dados['password'] != ''){
        $this->validate($request, [
          'password' => 'required|min:6|confirmed',
        ]);
        $dados['password'] = bcrypt($dados['password']);
      }else{
        unset($dados['password']);
      }

      $user->update($dados);

      return redirect()->route('site.perfil')->with('status', 'Perfil atualizado!');

    }

    public function favoritos()
    {
      if(Gate::denies('favoritos-view')){
        abort(403,"Não autorizado!");
      }

      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>'','titulo'=>'Lista de Favoritos']
      ];
      $user = Auth()->user();

      $carros = $user->carros;

      return view('site.favoritos',compact('carros','caminhos'));

    }

    public function favoritosCreate(Carro $carro)
    {
      if(Gate::denies('favoritos-create')){
        abort(403,"Não autorizado!");
      }
      $user = Auth()->user();
      $user->carros()->attach($carro);

      return redirect()->back();

    }

    public function favoritosDelete(Carro $carro)
    {
      if(Gate::denies('favoritos-delete')){
        abort(403,"Não autorizado!");
      }
      $user = Auth()->user();
      $user->carros()->detach($carro);

      return redirect()->back();

    }
}

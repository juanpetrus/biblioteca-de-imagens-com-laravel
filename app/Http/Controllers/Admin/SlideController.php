<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use App\Slide;
use App\Imagem;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Gate::denies('slides-view')){
        abort(403,"Não autorizado!");
      }

      $registros = Slide::where('deletado','=','N')->orderBy('ordem')->paginate(5);

      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>'','titulo'=>'Slides']
      ];

      return view('admin.slide.index',compact('registros','caminhos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(Gate::denies('slides-edit')){
        abort(403,"Não autorizado!");
      }

      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>route('slides.index'),'titulo'=>'Slides'],
      ['url'=>'','titulo'=>'Adicionar']
      ];

      if(Slide::where('deletado','=','N')->count()){
        $imagensSlide = Slide::where('deletado','=','N')->get();
      }else{
        $imagensSlide = null;
      }

      $imagens = Imagem::where('deletado','=','N')->orderBy('id','DESC')->paginate(6);

      return view('admin.slide.imagens',compact('imagens','caminhos','imagensSlide'));
    }


    public function storeSlide(Request $request)
    {
      if(Gate::denies('slides-edit')){
        abort(403,"Não autorizado!");
      }

      $dados = $request->all();


      $imagem = Imagem::find($dados['id']);

      $ordem= 1;
      if(Slide::where('deletado','=','N')->count()){
        $aux = Slide::where('deletado','=','N')->orderBy('ordem','DESC')->first();
        $ordem = $aux->ordem + 1;
      }

      if(Slide::where('imagem_id','=',$imagem->id)->count()){
        $aux = Slide::where('imagem_id','=',$imagem->id)->first();
        $aux->update(['deletado'=>'N','ordem'=>$ordem]);
      }else{
        Slide::create(['imagem_id'=>$imagem->id ,'link'=>'', 'ordem'=> $ordem]);
      }

      return Slide::all();
    }

    public function removeSlide(Request $request)
    {
      if(Gate::denies('slides-edit')){
        abort(403,"Não autorizado!");
      }
      $dados = $request->all();


      $imagem = Imagem::find($dados['id']);

      if(Slide::where('imagem_id','=',$imagem->id)->count() > 1){
        $galerias = Slide::where('imagem_id','=',$imagem->id)->get();
        foreach ($galerias as $galeria) {
          $galeria->update(['deletado'=>'S']);
        }
      }else{
        $galeria = Slide::where('imagem_id','=',$imagem->id)->first();
        $galeria->update(['deletado'=>'S']);
      }

      return Slide::all();
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
      if(Gate::denies('slides-edit')){
        abort(403,"Não autorizado!");
      }
      $registro = $slide;




      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>route('slides.index'),'titulo'=>'Slides'],
      ['url'=>'','titulo'=>'Editar']
      ];

      return view('admin.slide.editar',compact('registro','caminhos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slide $slide)
    {
      if(Gate::denies('slides-edit')){
        abort(403,"Não autorizado!");
      }

      $this->validate($request, [
            'ordem' => 'required|numeric',

      ]);

      $dados = $request->all();
      $registro = $slide;

      
      $registro->update($request->all());


      return redirect()->route('slides.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
      if(Gate::denies('slides-edit')){
        abort(403,"Não autorizado!");
      }

      $slide->update(['deletado'=>'S']);

      return redirect()->back();
    }
}

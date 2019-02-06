<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Gate;

use App\Carro;
use App\Marca;
use App\Categoria;
use App\Imagem;
use App\Galeria;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Gate::denies('carros-view')){
        abort(403,"Não autorizado!");
      }

      $registros = Carro::orderBy("id","DESC")->paginate(10);
      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>'','titulo'=>'Lista de carros']
      ];
      return view('admin.carro.index',compact('registros','caminhos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(Gate::denies('carros-create')){
        abort(403,"Não autorizado!");
      }

      $marcas = Marca::all();
      $categorias = Categoria::all();

      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>route('carros.index'),'titulo'=>'Carros'],
      ['url'=>'','titulo'=>'Adicionar']
      ];

      return view('admin.carro.adicionar',compact('caminhos','marcas','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
            'titulo' => 'required',
            'descricao' => 'required',
            'valor' => 'required|numeric',
            'ano' => 'required|numeric',
            'marca_id' => 'required|numeric',
      ]);

      $dados = $request->all();

      $carro = Carro::create($request->all());
      if(isset($dados['novasCategorias'])){
        foreach ($dados['novasCategorias'] as $key => $value) {
          $carro->categorias()->save(Categoria::find($value));
        }
      }

      return redirect()->route('carros.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Carro $carro)
    {
      if(Gate::denies('carros-edit')){
        abort(403,"Não autorizado!");
      }

      $registro = $carro;

      $marcas = Marca::all();
      $categorias = Categoria::all();

      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>route('carros.index'),'titulo'=>'Carros'],
      ['url'=>'','titulo'=>'Editar']
      ];

      return view('admin.carro.editar',compact('registro','caminhos','marcas','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carro $carro)
    {
      if(Gate::denies('carros-edit')){
        abort(403,"Não autorizado!");
      }

      $this->validate($request, [
            'titulo' => 'required',
            'descricao' => 'required',
            'valor' => 'required|numeric',
            'ano' => 'required|numeric',
            'marca_id' => 'required|numeric',
      ]);

      $dados = $request->all();
      $registro = $carro;

      $registro->update($request->all());
      foreach ($registro->categorias as $key => $value) {
        $registro->categorias()->detach($value);
      }
      if(isset($dados['novasCategorias'])){
        foreach ($dados['novasCategorias'] as $key => $value) {
          $registro->categorias()->save(Categoria::find($value));
        }
      }

      return redirect()->route('carros.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carro $carro)
    {
      if(Gate::denies('carros-delete')){
        abort(403,"Não autorizado!");
      }

      foreach ($carro->categorias as $key => $value) {
        $carro->categorias()->detach($value);
      }

      foreach ($carro->imagens as $key => $value) {
        $value->delete();
      }

      $carro->delete();
      return redirect()->route('carros.index');
    }

    public function indexGaleria(Carro $carro)
    {
      if(Gate::denies('carros-edit')){
        abort(403,"Não autorizado!");
      }

      $registros = $carro->imagens()->where('deletado','=','N')->orderBy('ordem')->paginate(5);

      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>route('carros.index'),'titulo'=>'Carros'],
      ['url'=>'','titulo'=>'Galeria']
      ];

      return view('admin.carro.galeria',compact('registros','caminhos','carro'));
    }

    public function createGaleria(Carro $carro)
    {
      if(Gate::denies('carros-edit')){
        abort(403,"Não autorizado!");
      }

      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>route('carros.index'),'titulo'=>'Carros'],
      ['url'=>route('carros.galeria.index',$carro),'titulo'=>'Galeria'],
      ['url'=>'','titulo'=>'Imagens']
      ];

      if($carro->imagens()->where('deletado','=','N')->count()){
        $imagensCarro = $carro->imagens()->where('deletado','=','N')->get();
      }else{
        $imagensCarro = null;
      }

      $imagens = Imagem::where('deletado','=','N')->orderBy('id','DESC')->paginate(6);

      return view('admin.carro.imagens',compact('imagens','caminhos','carro','imagensCarro'));
    }

    public function storeGaleria(Request $request)
    {
      if(Gate::denies('carros-edit')){
        abort(403,"Não autorizado!");
      }

      $dados = $request->all();

      $carro = Carro::find($dados['carro']);
      $imagem = Imagem::find($dados['id']);

      $ordem= 1;
      if($carro->imagens()->where('deletado','=','N')->count()){
        $aux = $carro->imagens()->where('deletado','=','N')->orderBy('ordem','DESC')->first();
        $ordem = $aux->ordem + 1;
      }

      if($carro->imagens()->where('imagem_id','=',$imagem->id)->count()){
        $aux = $carro->imagens()->where('imagem_id','=',$imagem->id)->first();
        $aux->update(['deletado'=>'N','ordem'=>$ordem]);
      }else{
        $carro->imagens()->create(['imagem_id'=>$imagem->id ,'url'=>$imagem->galeriaUrl(), 'ordem'=> $ordem]);
      }

      return $carro->imagens;
    }

    public function removeGaleria(Request $request)
    {
      if(Gate::denies('carros-edit')){
        abort(403,"Não autorizado!");
      }
      $dados = $request->all();

      $carro = Carro::find($dados['carro']);
      $imagem = Imagem::find($dados['id']);

      if($carro->imagens()->where('imagem_id','=',$imagem->id)->count() > 1){
        $galerias = $carro->imagens()->where('imagem_id','=',$imagem->id)->get();
        foreach ($galerias as $galeria) {
          $galeria->update(['deletado'=>'S']);
        }
      }else{
        $galeria = $carro->imagens()->where('imagem_id','=',$imagem->id)->first();
        $galeria->update(['deletado'=>'S']);
      }

      return $carro->imagens;
    }

    public function editGaleria(Galeria $galeria)
    {
      if(Gate::denies('carros-edit')){
        abort(403,"Não autorizado!");
      }
      $registro = $galeria;

      $carro = $galeria->carro;


      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>route('carros.index'),'titulo'=>'Carros'],
      ['url'=>route('carros.galeria.index',$carro),'titulo'=>'Galeria'],
      ['url'=>'','titulo'=>'Editar']
      ];

      return view('admin.carro.editargaleria',compact('registro','caminhos'));
    }

    public function updateGaleria(Request $request, Galeria $galeria)
    {
      if(Gate::denies('carros-edit')){
        abort(403,"Não autorizado!");
      }

      $this->validate($request, [
            'ordem' => 'required|numeric',

      ]);

      $dados = $request->all();
      $registro = $galeria;
      $carro = $galeria->carro;

      $registro->update($request->all());


      return redirect()->route('carros.galeria.index',$carro);

    }

    public function deleteGaleria(Request $request,Galeria $galeria)
    {
      if(Gate::denies('carros-edit')){
        abort(403,"Não autorizado!");
      }

      $galeria->update(['deletado'=>'S']); 

      return redirect()->back();
    }


}

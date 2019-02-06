<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Imagem;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;

class ImagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Gate::denies('imagens-view')){
        abort(403,"Não autorizado!");
      }

      $registros = Imagem::where('deletado','=','N')->orderBy('id','DESC')->paginate(5);
      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>'','titulo'=>'Imagens']
      ];
      return view('admin.imagem.index',compact('registros','caminhos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('imagens-create')){
          abort(403,"Não autorizado!");
        }

        $caminhos = [
        ['url'=>'/admin','titulo'=>'Admin'],
        ['url'=>route('imagens.index'),'titulo'=>'Imagens'],
        ['url'=>'','titulo'=>'Adicionar']
        ];

        return view('admin.imagem.adicionar',compact('caminhos'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('imagens-create')){
          abort(403,"Não autorizado!");
        }

        if($request->hasFile('imagens')){

          $imagens = $request->imagens;

          $imagemRegras = array(
            'imagem' => 'required|image|dimensions:min_width=600,min_height=600',
          );

          foreach($imagens as $imagem){
            $imagemArray = array('imagem' => $imagem);
            $imageValidator = Validator::make($imagemArray, $imagemRegras);
            if ($imageValidator->fails()) {
              return redirect()->route('imagens.create')
                          ->withErrors($imageValidator)
                          ->withInput();
            }
          }

          foreach ($imagens as $imagem) {
            $imagem_nome = time().$imagem->getClientOriginalName();
            $imagem->move("imagens/",$imagem_nome);

            $tamPeq = explode("x",config('app.imagemPequena'));
            $tamG = explode("x",config('app.imagemGaleria'));
            $tamS = explode("x",config('app.imagemSlide'));

            $image1 = Image::make("imagens/".$imagem_nome)->fit($tamPeq[0],$tamPeq[1])->save("imagens/pequena-".$imagem_nome);
            $image2 = Image::make("imagens/".$imagem_nome)->fit($tamG[0],$tamG[1])->save("imagens/galeria-".$imagem_nome);
            $image3 = Image::make("imagens/".$imagem_nome)->fit($tamS[0],$tamS[1])->save("imagens/slide-".$imagem_nome);

            $auxNome = explode(".",$imagem->getClientOriginalName());
            $imagemModel = Imagem::create(["titulo"=>$auxNome[0],"descricao"=>""]);
            $imagemModel->arquivos()->create(["url"=>"imagens/pequena-".$imagem_nome,"tamanho"=>"P"]);
            $imagemModel->arquivos()->create(["url"=>"imagens/galeria-".$imagem_nome,"tamanho"=>"G"]);
            $imagemModel->arquivos()->create(["url"=>"imagens/slide-".$imagem_nome,"tamanho"=>"S"]);

          }

        }

        return redirect()->route('imagens.index');
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
    public function edit($id)
    {
        if(Gate::denies('imagens-edit')){
          abort(403,"Não autorizado!");
        }

        $registro = Imagem::find($id);

        $caminhos = [
        ['url'=>'/admin','titulo'=>'Admin'],
        ['url'=>route('imagens.index'),'titulo'=>'Imagens'],
        ['url'=>'','titulo'=>'Editar']
        ];

        return view('admin.imagem.editar',compact('caminhos','registro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::denies('imagens-edit')){
          abort(403,"Não autorizado!");
        }
        $this->validate($request, [
          'titulo' => 'required',
        ]);
        $registro = Imagem::find($id);
        $registro->update($request->all());

        if($request->hasFile('imagem')){
          $this->validate($request, [
                'imagem' => 'required|image|dimensions:min_width=600,min_height=600',
          ]);

          $imagem = $request->file('imagem');

          $imagem_nome = time().$imagem->getClientOriginalName();
          $imagem->move("imagens/",$imagem_nome);

          $tamPeq = explode("x",config('app.imagemPequena'));
          $tamG = explode("x",config('app.imagemGaleria'));
          $tamS = explode("x",config('app.imagemSlide'));

          $image1 = Image::make("imagens/".$imagem_nome)->fit($tamPeq[0],$tamPeq[1])->save("imagens/pequena-".$imagem_nome);
          $image2 = Image::make("imagens/".$imagem_nome)->fit($tamG[0],$tamG[1])->save("imagens/galeria-".$imagem_nome);
          $image3 = Image::make("imagens/".$imagem_nome)->fit($tamS[0],$tamS[1])->save("imagens/slide-".$imagem_nome);

          $auxNome = explode(".",$imagem->getClientOriginalName());

          $imagPequena = $registro->arquivos()->where('tamanho','=','P')->first();
          $imagGaleria = $registro->arquivos()->where('tamanho','=','G')->first();
          $imagSlide = $registro->arquivos()->where('tamanho','=','S')->first();

          $imagPequena->update(["url"=>"imagens/pequena-".$imagem_nome]);
          $imagGaleria->update(["url"=>"imagens/galeria-".$imagem_nome]);
          $imagSlide->update(["url"=>"imagens/slide-".$imagem_nome]);

        }

        return redirect()->route('imagens.edit',$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('imagens-delete')){
          abort(403,"Não autorizado!");
        }

        Imagem::find($id)->update(['deletado'=>'S']);

        return redirect()->route('imagens.index');

    }

    public function excluidas()
    {
      if(Gate::denies('imagens-edit')){
        abort(403,"Não autorizado!");
      }

      $registros = Imagem::where('deletado','=','S')->orderBy('id','DESC')->paginate(5);
      $caminhos = [
      ['url'=>'/admin','titulo'=>'Admin'],
      ['url'=>route('imagens.index'),'titulo'=>'Imagens'],
      ['url'=>'','titulo'=>'Excluídas']
      ];
      return view('admin.imagem.excluidas',compact('registros','caminhos'));
    }

    public function recupera($id)
    {
        if(Gate::denies('imagens-edit')){
          abort(403,"Não autorizado!");
        }

        Imagem::find($id)->update(['deletado'=>'N']);

        return redirect()->route('imagens.excluidas');

    }
}

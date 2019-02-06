<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;


class testeImagemController extends Controller
{
    public function teste1()
    {
      return view("teste1");
    }

    public function teste1Post(Request $request)
    {

      $this->validate($request,[
        "imagem"=>"required|image|dimensions:min_width=600,min_height=600"
      ],[
        "imagem.required"=>"Preencha uma imagem"
      ]);

      if($request->hasFile('imagem')){
        //$imagem = $request->file('imagem');
        $imagem = $request->imagem;
        $imagem_nome = time().$imagem->getClientOriginalName();

        $imagem->move("imagem/",$imagem_nome);

        //$image = Image::make("imagem/".$imagem_nome)->resize(300, 200)->save("imagem/300_200_".$imagem_nome);
        $image = Image::make("imagem/".$imagem_nome)->fit(1200,600)->brightness(-20)->save("imagem/slide3_".$imagem_nome);
        $image = Image::make("imagem/".$imagem_nome)->fit(400,400)->save("imagem/pequena_".$imagem_nome);
        $image = Image::make("imagem/".$imagem_nome)->fit(600,400)->save("imagem/galeria_".$imagem_nome);

        dd("feito");
      }

      return "OK";
    }

    public function teste2()
    {
      return view("teste2");
    }

    public function teste2Post(Request $request)
    {
      if($request->hasFile('imagens')){

        $imagens = $request->imagens;

        $imagemRegras = array(
          'imagem' => 'required|image|dimensions:min_width=600,min_height=600',
        );

        foreach($imagens as $imagem){
          $imagemArray = array('imagem' => $imagem);
          $imageValidator = Validator::make($imagemArray, $imagemRegras);
          if ($imageValidator->fails()) {
            return redirect('teste2')
                        ->withErrors($imageValidator)
                        ->withInput();
          }
        }

        foreach ($imagens as $imagem) {
          $imagem_nome = time().$imagem->getClientOriginalName();
          $imagem->move("multiplas2/",$imagem_nome);
        }

      }

      return "OK";
    }
}

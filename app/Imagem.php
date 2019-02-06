<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    protected $table = "imagens";
    protected $fillable = [
      "titulo","descricao","deletado"
    ];

    public function arquivos()
    {
      return $this->hasMany('App\Arquivo');
    }

    public function pequenaUrl()
    {
      $url = asset($this->arquivos()->where('tamanho','=','P')->first()->url);
      return $url;
    }

    public function galeriaUrl()
    {
      $url = asset($this->arquivos()->where('tamanho','=','G')->first()->url);
      return $url;
    }

    public function slideUrl()
    {
      $url = asset($this->arquivos()->where('tamanho','=','S')->first()->url);
      return $url;
    }

}

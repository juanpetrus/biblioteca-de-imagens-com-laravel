<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
  protected $fillable = [
      'imagem_id','titulo', 'descricao', 'url', 'ordem','deletado'
  ];

  public function carro()
  {
    return $this->belongsTo('App\Carro');
  }

  public function imagem()
  {
    return $this->belongsTo('App\Imagem');
  }

  public function getUrlAttribute($value)
  {
      $imagem = $this->imagem;
      $url = $imagem->arquivos()->where('tamanho','=','G')->first()->url;

      return asset($url);
  }

}

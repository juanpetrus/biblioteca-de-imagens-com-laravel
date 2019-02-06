<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    protected $fillable = [
      "imagem_id","url","tamanho"
    ];

    public function imagem()
    {
      return $this->belongsTo('App\Imagem');
    }


}

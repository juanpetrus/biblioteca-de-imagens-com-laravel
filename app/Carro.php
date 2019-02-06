<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    protected $fillable = [
        'marca_id','titulo', 'descricao', 'ano', 'valor'
    ];

    public function marca()
    {
      return $this->belongsTo('App\Marca');
    }

    public function categorias()
    {
      return $this->belongsToMany('App\Categoria');
    }

    public function usuarios()
    {
      return $this->belongsToMany('App\User');
    }

    public function imagens()
    {
      return $this->hasMany('App\Galeria');
    }

    public function getTextoValorAttribute($value)
    {
        $valor = "R$ ".number_format($this->valor,2,",",".");
        return $valor;
    }

    public function getTextoCategoriasAttribute($value)
    {
        $categorias = $this->categorias;
        $texto = "";
        foreach ($categorias as $key => $value) {
          if($key == 0){
            $texto .= $value->titulo;
          }else{
            $texto .= ", ".$value->titulo;
          }

        }
        return $texto;
    }

}

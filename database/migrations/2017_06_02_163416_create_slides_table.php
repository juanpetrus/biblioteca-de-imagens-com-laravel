<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('imagem_id')->unsigned()->default(1)->after('carro_id');
          $table->foreign('imagem_id')->references('id')->on('imagens');
          $table->string('titulo')->nullable();
          $table->string('descricao')->nullable();
          $table->string('link')->nullable();
          $table->integer('ordem');
          $table->enum('deletado',["N","S"])->default("N");
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
}

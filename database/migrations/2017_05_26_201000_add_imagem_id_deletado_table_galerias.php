<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagemIdDeletadoTableGalerias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galerias', function (Blueprint $table) {
          $table->integer('imagem_id')->unsigned()->default(1)->after('carro_id');
          $table->foreign('imagem_id')->references('id')->on('imagens');

          $table->enum('deletado',["N","S"])->default("N");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galerias', function (Blueprint $table) {
          $table->dropColumn('deletado');
          $table->dropColumn('imagem_id');
        });
    }
}

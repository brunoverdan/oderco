<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotacaoFretesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacao_fretes', function (Blueprint $table) {
            $table->id();
            $table->string('uf', 2);
            $table->decimal('porcentual_cotacao', 10,2);
            $table->decimal('valor_extra', 10,2);
            $table->foreignId('transportadora_id')->constrained('transportadoras');
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
        Schema::dropIfExists('cotacao_fretes');
    }
}

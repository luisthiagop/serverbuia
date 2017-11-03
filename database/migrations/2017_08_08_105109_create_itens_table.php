<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('itens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('festa_id', false, true);
            $table->string('nome')->nullable(false);
            $table->decimal('preco_individual', 10, 2)->nullable(false);
            $table->integer('quantidade')->nullable(false);
            $table->timestamps();
            $table->foreign('festa_id')->references('id')->on('festas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('itens');
    }
}

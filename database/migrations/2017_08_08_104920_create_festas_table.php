<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFestasTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('festas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->string('nome')->nullable(false);
            $table->text('descricao')->nullable(false);
            $table->decimal('valor_ingresso', 10, 2)->nullable(false);
            $table->string('endereco')->nullable(false);
            $table->string('cidade')->nullable(false);
            $table->string('estado')->nullable(false);
            $table->string('pais')->nullable(false);
            $table->timestamp('data')->nullable(false);
            $table->boolean('particular')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('festas');
    }
}

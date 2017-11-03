<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvidadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convidados', function (Blueprint $table) {
            $table->integer('user_id', false, true);
            $table->boolean('tem_permissao_convite')->default(false);
            $table->integer('festa_id', false, true);
            $table->dateTime('hora_entrada')->nullable(false);
            $table->char('presenca', 1)->nullable(false);
            $table->timestamps();

            $table->primary(['user_id', 'festa_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('festa_id')->references('id')->on('festas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convidados');
    }
}

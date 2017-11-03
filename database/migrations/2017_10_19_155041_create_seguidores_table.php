<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguidoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguidores', function (Blueprint $table) {
            $table->unsignedInteger('seguindo');
            $table->unsignedInteger('seguidor');

            $table->primary(['seguidor', 'seguindo']);

            $table->foreign('seguindo')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seguidor')->references('id')->on('users')->onDelete('cascade');

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
        //
    }
}

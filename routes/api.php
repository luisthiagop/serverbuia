<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('auth/cadastro', 'Auth\RegisterController@store');
Route::post('auth/login', 'Auth\LoginController@store');

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'destroy']]);
Route::get('users/festas/{id}', 'UsersController@festas')->name('users.festas');
Route::get('users/convidado', 'UsersController@proxConvidados')->name('users.convidado');
Route::get('users/confirmado', 'UsersController@proxConfirmados')->name('users.confirmado');
Route::get('users/organiza', 'UsersController@organiza')->name('users.organiza');

Route::resource('eventos', 'EventosController', ['except' => ['create', 'edit']]);

Route::resource('itens', 'ItensController', ['except' => ['index', 'create', 'edit']]);
Route::get('itens/festa/{idfesta}', 'ItensController@festa')->name('itens.festa');

Route::resource('convidados', 'ConvidadosController', ['only' => ['store', 'update', 'destroy']]);
Route::get('convidados/{idfesta}', 'ConvidadosController@convidados');
Route::get('convidados/{idfesta}/{idusuario}', 'ConvidadosController@convidado');

Route::resource('seguidores', 'SeguidoresController', ['only' => ['store', 'destroy']]);
Route::get('seguidores/seguindo/{id}', 'SeguidoresController@seguindo')->name('seguidores.seguindo');
Route::get('seguidores/{id}', 'SeguidoresController@seguidores')->name('seguidores.seguindo');
Route::get('seguidores/sigo', 'SeguidoresController@sigo')->name('seguidores.sigo');

Route::resource('mensagens', 'MensagensController', ['except' => ['index', 'create', 'edit']]);
Route::get('mensagens/festa/{idfesta}', 'MensagensController@mensagens')->name('mensagens.festa');

Route::resource('fotos', 'FotosController', ['except' => ['index', 'create', 'edit']]);
Route::get('fotos/{idfesta}', 'FotosController@fotos')->name('fotos.index');
Route::put('fotos/aprova/{id}', 'FotosController@aprovacao')->name('fotos.aprovacao');

Route::resource('acompanhantes', 'AcompanhantesController', ['except' => 'index', 'create', 'edit']);
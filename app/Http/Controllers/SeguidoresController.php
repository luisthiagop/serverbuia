<?php

namespace App\Http\Controllers;

use App\Seguidor;
use Illuminate\Http\Request;

class SeguidoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['update', 'destroy', 'sigo']]);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'seguidor' => 'required|exists:users,id',
                'seguindo' => 'required|exists:users,id'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $seguidor = new Seguidor();
            $seguidor->fill($request->all());
            $seguidor->save();
            return response()->json($seguidor);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seguidor $seguidor
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seguidor $seguidor
     * @return \Illuminate\Http\Response
     */
    public function edit(Seguidor $seguidor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Seguidor $seguidor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seguidor $seguidor)
    {
        //Não há necessidade de atualizar o seguidor
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seguidor $seguidor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $seguindo)
    {
        try {
            $userid = $request->user();
            $seguidor = Seguidor::where('seguindo', $seguindo)->where('seguido', $userid);
            if ($seguidor->delete() > 0)
                return response('Parou de seguir');
            return response('Ninguem encontrado', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    //Função para encontrar quem eu estou seguindo
    public function seguindo(Request $request, $id)
    {
        try {
            $seguindo = Seguidor::where('seguidor', $id)->get();
            if ($seguindo > 0)
                return response()->json($seguindo);
            return response('Nao segue ninguem', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 419);
        }
    }

    //Função para encontrar os seguidores
    public function seguidores(Request $request, $id)
    {
        try {
            $seguindo = Seguidor::where('seguindo', $id)->get();
            if ($seguindo > 0)
                return response()->json($seguindo);
            return response('Nao é seguido', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 419);
        }
    }

    //Função para verificar se eu sigo uma pessoa
    public function sigo(Request $request, $id)
    {
        try {
            $userid = $request->user();
            $seguindo = Seguidor::where('seguindo', $id)->where('seguidor', $userid)->get();
            if ($seguindo > 0)
                return response('Segue', 200);
            return response('Nao segue', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 419);
        }
    }
}

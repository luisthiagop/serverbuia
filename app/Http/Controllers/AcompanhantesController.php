<?php

namespace App\Http\Controllers;

use App\Acompanhante;
use Illuminate\Http\Request;

class AcompanhantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api',
            ['only' => ['store', 'update', 'destroy', 'show']]
        );
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
            //Necessita verificar se o usuário foi convidado para a festa antes
            $user = $request->user();
            $validator = Validator::make($request->all(), [
                'sexo' => 'required|char|size:1',
                'user_id' => 'required|integer|exists:users,id',
                'festa_id' => 'required|integer|exists:festas,id',
                'hora_entrada' => 'date',
                'presenca' => 'alpha|max:1'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $acompanhante = new Acompanhante();
            $acompanhante->fill($request->all());
            $acompanhante->user_id = $user->id;
            $acompanhante->save();
            return response()->json($acompanhante);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Acompanhante $acompanhante
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $festaid)
    {
        //
        $userid = $request->user();
        $acompanhante = Acompanhante::where('user_id', $userid)->where('festa_id', $festaid);
        if ($acompanhante > 0)
            return response()->json($acompanhante);
        return response('Nenhum usuário encontrado', 204);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Acompanhante $acompanhante
     * @return \Illuminate\Http\Response
     */
    public function edit(Acompanhante $acompanhante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Acompanhante $acompanhante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $festaid)
    {
        try {
            $user = $request->user();
            $acompanhante = Acompanhante::where('user_id', $user->id)->where('festa_id', $festaid);
            $validator = Validator::make($request->all(), [
                'sexo' => 'required|char|size:1',
                'hora_entrada' => 'date',
                'presenca' => 'alpha|max:1'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $acompanhante->fill($request->all());
            $acompanhante->update();
            return response()->json($acompanhante);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Acompanhante $acompanhante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $festaid)
    {
        $userid = $request->user();
        $acompanhante = Acompanhante::where('user_id', $userid)->where('festa_id', $festaid)->get();
        if ($acompanhante > 0)
            return response('Acompanhante deletado');
        return response('Nenhum acompanhante deletado', 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Convidado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Response;

class ConvidadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api',
            ['only' => ['store', 'show', 'update', 'destroy', 'convidados', 'convidado']]
        );
    }

    public function index()
    {
        //Não usa
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
            $user = $request->user();
            $encontrou = 0;
            if (Convidado::where('user_id', $user->id)->get() > 0)
                $encontrou = 1;
            if (DB::table('festas')->where('user_id', $user->id)->get() > 0)
                $encontrou = 1;
            if ($encontrou != 1)
                return response("Forbidden", 403);
            $validator = Validator::make($request->all(), [
                'tem_permissao_convite' => 'required|bool',
                'user_id' => 'required|integer',
                'festa_id' => 'required|integer',
                'hora_entrada' => 'date',
                'presenca' => 'alpha|max:1'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $convidado = new Convidado();
            $convidado->fill($request->all());
            $convidado->save();
            return response()->json([$convidado]);

        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Convidado $convidado
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Convidado $convidado
     * @return \Illuminate\Http\Response
     */
    public function edit(Convidado $convidado)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Convidado $convidado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $userid = $request->user();
            if (DB::table('festas')->where('user_id', $userid)->get() == 0)
                return response("Forbidden", 403);

            $convidado = Convidado::where('user_id', $request->user_id)->where('festa_id', $request->festa_id);
            $validator = Validator::make($request->all(), [
                'tem_permissao_convite' => 'required|bool',
                'hora_entrada' => 'date',
                'presenca' => 'alpha|max:1'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $convidado->tem_permissao_convite = $request->tem_permissao_convite;
            $convidado->update($request->all());
            return response()->json($convidado);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Convidado $convidado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $convidado = Convidado::where('user_id', $request->user_id)->where('festa_id', $request->festa_id);
            if ($convidado->delete() > 0)
                return response('Usuario deletado', 200);
            else
                return response('Nenhum usuário encontrado', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    //Retorna todos os convidados de uma festa
    public function convidados(Request $request, $idfesta)
    {
        try {
            //Verificar se a festa é particular
            //Se for particular, só retornar se o usuário logado for convidado
            $convidados = Convidado::where('festa_id', $idfesta)->get();
            return response()->json($convidados);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    //Retorna se a pessoa foi convidada para a festa
    public function convidado(Request $request, $idfesta, $idusuario)
    {
        //Verificar se a festa não é particular
        //Se for, somente poderá mostrar se o usuário logado for um convidado
        $convidado = Convidado::where('user_id', $idusuario)->where('festa_id', $idfesta)->get();
        return response()->json($convidado);
    }
}

<?php

namespace App\Http\Controllers;

use App\Mensagem;
use Illuminate\Http\Request;

class MensagensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api',
            ['only' => ['store', 'show', 'update', 'destroy', 'mensagens']]
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
            $user = $request->user();
            $validator = Validator::make($request->all(), [
                'festa_id' => 'required|exists:festas,id',
                'titulo' => 'required|string',
                'texto' => 'required|string'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $mensagem = new Mensagem();
            $mensagem->fill($request->all());
            $mensagem->user_id = $user->id;
            $mensagem->save();
            return response()->json($mensagem);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mensagem $mensagem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
         * Necessita ver se a festa é publica
         * Se for privada, se o usuário foi convidado
         */
        try {
            $mensagens = Mensagem::find($id)->get();
            if ($mensagens > 0)
                return response()->json($mensagens);
            else
                return response('Nenhuma mensagem encontrada', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mensagem $mensagem
     * @return \Illuminate\Http\Response
     */
    public function edit(Mensagem $mensagem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Mensagem $mensagem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $mensagem = Mensagem::find($id);
            $user = $request->user();
            if ($mensagem->user_id != $user->id)
                return response('Forbidden', 403);
            $validator = Validator::make($request->all(), [
                'titulo' => 'required|string',
                'texto' => 'required|string'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $mensagem->fill($request->all());
            $mensagem->update();
            return response()->json($mensagem);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mensagem $mensagem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $user = $request->user();
            $dono = DB::table('festas')->where('user_id', $user->id)->get();
            if ($dono == 0)
                return response('Forbidden', 403);
            $dono = Mensagem::where('user_id', $user->id);
            if ($dono == 0)
                return response('Forbidden', 403);
            if (Mensagem::destroy($id) > 0)
                return response('Mensagem deletada', 200);
            return response('Nenhuma mensagem deletada', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    //Retorna todas as mensagens de um evento
    public function mensagens(Request $request, $festa_id)
    {
        try {
            $user = $request->user();
            $mensagem = Mensagem::where('festa_id', $festa_id)->get();
            $evento = DB::table('eventos')
                ->where('id', $festa_id)
                ->where('particular', true)
                ->get();
            if ($evento == 0) {//Se o evento não for particular
                if ($mensagem > 0)
                    return response()->json($mensagem);
                return response('Nenhuma mensagem encontrada', 204);
            }
            $convidado = DB::table('convidados')
                ->where('user_id', $user->id)
                ->where('festa_id', $festa_id)
                ->get();
            if ($convidado == 0)//Se o usuário não foi convidado
                return response('Forbidden', 403);
            if ($mensagem > 0)
                return response()->json($mensagem);
            return response('Nenhuma mensagem encontrada', 204);

        } catch
        (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }
}

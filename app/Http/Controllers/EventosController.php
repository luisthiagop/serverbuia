<?php

namespace App\Http\Controllers;

use App\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class EventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api',
            ['only' => ['show', 'update', 'destroy']]
        );
    }

    public function index()
    {
        try {
            $eventos = Evento::where('particular', false)
                ->limit(10)
                ->get();
            if ($eventos > 0)
                return response()->json($eventos);
            return response('Nenhum evento publico', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }
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
                'nome' => 'required|string|alpha_dash',
                'descricao' => 'required|string|alpha_dash',
                'valor_ingresso' => 'required',
                'endereco' => 'required|max:255|min:3|string',
                'cidade' => 'required|max:255|min:3|string',
                'pais' => 'required|max:255|min:3|string',
                'data' => 'required|date_format:Ymd',
                'particular' => 'required|boolean'
            ]);
            if ($validator->fails())
                return response($validator->errors(), 419);
            $evento = new Evento();
            $user = $request->user();
            $evento->fill($request->all());
            $evento->user_id = $user->id;
            if ($evento->save())
                return response()->json($evento);
            return response('Erro ao salvar evento', 419);


        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show(Request $request, $id)
    {
        try {
            $evento = Evento::where('id', $id)->get();
            if ($evento->particular = false)
                return response()->json($evento);
            $user = $request->user();
            $convidado = DB::table('convidados')
                ->where('festa_id', $id)
                ->where('user_id', $user->id)
                ->get();
            if ($convidado == 0)
                return response('Forbidden', 403);
            return response()->json($evento);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        try {
            $evento = Evento::find($id);
            if ($evento == 0)
                return response('Nenhum evento encontrado', 204);
            $userid = $request->user();
            if ($evento->user_id != $userid)
                return response("Forbidden", 403);
            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|alpha_dash',
                'descricao' => 'required|string|alpha_dash',
                'valor_ingresso' => 'required',
                'endereco' => 'required|max:255|min:3|string',
                'cidade' => 'required|max:255|min:3|string',
                'pais' => 'required|max:255|min:3|string',
                'data' => 'required|date_format:Ymd',
                'particular' => 'required|boolean'
            ]);
            if ($validator->fails())
                return response($validator->errors(), 419);
            $evento->update($request->all());
            return response()->json($evento);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            if ($evento = Evento::find($id) == 0)
                return response('Nenhum usuário deletado', 204);
            $userid = $request->user();
            if ($evento->user_id != $userid)
                return response('Forbidden', 403);
            $evento->delete();
            return response('Evento deletado', 200);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }
    }
}

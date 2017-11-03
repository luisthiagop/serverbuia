<?php

namespace App\Http\Controllers;

use App\Foto;
use Illuminate\Http\Request;

class FotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api',
            ['only' => ['store', 'show', 'update', 'destroy', 'fotos', 'aprovacao']]
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
            $validator = Validator::make($request->all(), [
                'festa_id' => 'required',
                'path' => 'required|string'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $user = $request->user();
            $convidado = DB::table('convidado')
                ->where('festa_id', $request->festa_id)
                ->where('user_id', $user->id)
                ->get();
            if ($convidado == 0)
                return response('Forbidden', 403);
            $foto = new Foto();
            $foto->fill($request->all());
            $foto->update();
            return response()->json($foto);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Foto $foto
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        /*
        * Necessita ver se a festa é publica
        * Se for privada, se o usuário foi convidado
        * Se a foto não foi aprovada, somente o dono da festa e o usuário que subiu podem ver
        */
        try {
            $foto = Foto::find($id);
            $user = $request->user();
            if ($foto->aprovada == false) {
                //
            }
            if ($foto > 0)
                return response()->json($foto);
            else
                return response('Nenhuma foto encontrada', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Foto $foto
     * @return \Illuminate\Http\Response
     */
    public function edit(Foto $foto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Foto $foto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $foto = Foto::find($id);
            if ($foto == 0)
                return response('Nenhuma foto encontrada', 204);
            $user = $request->user();
            if ($foto->user_id != $user->id)
                return response('Forbidden', 403);
            $validator = Validator::make($request->path, [
                'path' => 'required|string'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $foto->fill($request->all());
            $foto->update();
            return response()->json($foto);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Foto $foto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $user = $request->user();
            $dono = DB::table('festas')->where('user_id', $user->id)->get();
            if ($dono == 0)
                return response('Forbidden', 403);
            $dono = Foto::where('user_id', $user->id);
            if ($dono == 0)
                return response('Forbidden', 403);
            if (Mensagem::destroy($id) > 0)
                return response('Foto deletada', 200);
            return response('Nenhuma foto deletada', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    //Busca todas as fotos aprovadas do evento
    public function fotos(Request $request, $festa_id)
    {
        try {
            $user = $request->user();
            $fotos = Foto::where('festa_id', $festa_id)
                ->where('aprovada', true)
                ->get();
            $evento = DB::table('eventos')
                ->where('id', $festa_id)
                ->where('particular', true)
                ->get();
            if ($evento == 0) {//Se o evento não for particular
                if ($fotos > 0)
                    return response()->json($fotos);
                return response('Nenhuma foto encontrada', 204);
            }
            $convidado = DB::table('convidados')
                ->where('user_id', $user->id)
                ->where('festa_id', $festa_id)
                ->get();
            if ($convidado == 0)//Se o usuário não foi convidado
                return response('Forbidden', 403);
            if ($fotos > 0)
                return response()->json($fotos);
            return response('Nenhuma mensagem encontrada', 204);


        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    //Função para aprovação da foto
    public function aprovacao(Request $request, $id)
    {
        try {
            $foto = Foto::find($id);
            if ($foto == 0)
                return response('Nenhuma foto encontrada', 204);
            $user = $request->user();
            $evento = DB::table('eventos')
                ->where('id', $foto->festa_id)
                ->where('user_id', $user->id)
                ->get();
            if ($evento == 0)
                return response('Forbidden', 403);
            $validator = Validator::make($request->path, [
                'aprovada' => 'required|boolean'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $foto->fill($request->all());
            $foto->update();
            return response()->json($foto);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }
}

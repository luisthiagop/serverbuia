<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',
            ['only' => ['update', 'destroy', 'proxConvidados', 'proxConfirmados', 'organiza']]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return User::all();
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
        //return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(User::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request)
    {
        $user = $request->user();
        try {
            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:255|alpha|min:3',
                'cpf' => ['size:11', Rule::unique('users')->ignore($user->id)],
                'email' => 'required|string|email|max:255', Rule::unique('users')->ignore($user->id),
                'data_nascimento' => 'required|date_format:Ymd',
                'foto' => 'string'
            ]);
            if ($validator->fails())
                return response($validator->errors(), 419);
            $user->update($request->all());
            return response()->json($user);
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
    public function destroy($id)
    {
        try {
            $user = User::destroy($id);
            if ($user > 0)
                return response('User deleted', 200);
            return response('User not found', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }
    }

    //Função para verificar todas as festas públicas que o usuário foi
    public function festas(Request $request, $id)
    {
        try {
            $festa = DB::table('festas')
                ->where('particular', false)
                ->join('convidados', 'festa.id', '=', 'convidados.festa_id')
                ->where('convidados.presenca', 'C')
                ->where('convidados.user_id', $id)
                ->get();
            if ($festa > 0)
                return response()->json($festa);
            return response('Nao participou de nenhuma festa publica', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }
    }

    //Função para verificar os próximos eventos que ele foi convidado
    public function proxConvidados(Request $request)
    {
        try {
            $userid = $request->user();
            $festa = DB::table('festas')
                ->where('data', '>=', 'now')
                ->join('convidados', 'festa.id', '=', 'convidados.festa_id')
                ->where('convidados.user_id', $userid)
                ->get();
            if ($festa > 0)
                return response()->json($festa);
            return response('Nenhum evento futuro', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }
    }

    //Função para verificar os próximos eventos que ele confirmou presença
    public function proxConfirmados(Request $request)
    {
        try {
            $user = $request->user();
            $festas = DB::table('festas')
                ->where('data', '>=', 'now')
                ->join('convidados', 'festa.id', '=', 'convidados.festa_id')
                ->where('convidados.presenca', 'C')
                ->where('convidados.user_id', $user->id)
                ->get();
            if ($festas > 0)
                return response()->json($festas);
            return response('Nenhuma festa encontrada', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }
    }

    //Função para verificar os próximos eventos que o usuário organiza
    public function organiza(Request $request)
    {
        try {
            $user = $request->user();
            $festas = DB::table('festas')
                ->where('data', '>=', 'now')
                ->where('user_id', $user->id);
            if ($festas > 0)
                return response()->json($festas);
            return response('Não organiza nenhuma festa', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }
    }
}

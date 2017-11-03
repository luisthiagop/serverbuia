<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class ItensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api',
            ['only' => ['store', 'update', 'destroy']]
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
                'festa_id' => 'required|exists:festas,id',
                'nome' => 'required|string|min:3|alpha|max:255',
                'preco_individual' => 'required|decimal|min:0.0',
                'quantidade' => 'required|integer|min:0'
            ]);
            if ($validator->fails())
                return response($validator->errors(), '419');
            $item = new Item();
            $item->fill($request->all());
            $item->save();
            return response()->json($item);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), '401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $item = Itens::find($id);
            if ($item > 0)
                return response()->json($item);
            return response('Nenhum item encontrado', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 419);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //Não usa
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Itens::find(id);
        try {
            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:255|alpha|min:3',
                'preco_individual' => 'required|decimal|min:0.0',
                'quantidade' => 'required|integer|min:0'
            ]);
            if ($validator->fails())
                return response($validator->errors(), 419);
            $item->update($request->all());
            return response()->json($item);
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
    public function destroy($festa_id)
    {
        try {
            if (Itens::destroy($festa_id) > 0)
                return response('Item deletado', 200);
            return response('Nenhum item deletado', 204);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 401);
        }
    }

    //Retorna todos os itens da festa
    public function festa($id)
    {
        //
    }
}

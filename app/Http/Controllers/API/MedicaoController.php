<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Medicao;
use App\API\ApiError;

class MedicaoController extends Controller
{
    private $medicao;

    public function __construct(Medicao $medicao)
	{
		$this->medicao = $medicao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['data' => $this->medicao::with('sensor')->get()];
        return response() -> json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $medicaodata = $request->all();
            $this->medicao->create($medicaodata);

			$return = ['data' => ['msg' => 'medicao criada com sucesso.']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500), 500);
			}
			return response()->json(ApiError::errorMessage('houve um erro ao realizar operação de salvar', 500),  500);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Medicao $id)
    {
        $medicao = $this->medicao::with('sensor')->find($id);
        if(!$medicao) return response()->json(ApiError::errorMessage('medicao não encontrado.', 404), 404);
        
        $data = ['data' => $medicao];
        return response() -> json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $medicaodata = $request->all();
            $medicao = $this->medicao->find($id);
            $medicao->update($medicaodata);

			$return = ['data' => ['msg' => 'medicao atualizada com sucesso.']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500),  500);
			}
			return response()->json(ApiError::errorMessage('houve um erro ao realizar operação de atualizar', 500), 500);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicao $id)
    {
        try {
            
            $id->delete();
            return response()-> json(['data'=> ['msg'=> 'medicao: '.$id->id. ' deletada com sucesso.']],200);

		}catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500),  500);
			}
			return response()->json(ApiError::errorMessage('houve um erro ao realizar operação de deletar', 500),  500);
		}
    }
}

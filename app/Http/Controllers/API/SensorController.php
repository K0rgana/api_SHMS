<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Sensor;
use App\API\ApiError;

class SensorController extends Controller
{
    private $sensor;

    public function __construct(Sensor $sensor)
	{
		$this->sensor = $sensor;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(sizeof($this->sensor->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'nenhum sensor cadastrado']], 404);
        }
        else{
            $data = ['data' => $this->sensor::all()];
            return response() -> json($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|min:2|max:100',
            'tipo' => 'in:temperatura, luminosidade, presenca, magnetico|required|min:8|max:12'
        ]);
        
        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        try {
            $sensordata = $request->all();
            $this->sensor->create($sensordata);

			$return = ['data' => ['msg' => 'sensor criado com sucesso.']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500), 500);
			}
			if(is_null($sensors)) {
                return response()->json(['data'=>['msg'=>'sensor não encontrado!']], 404);
            }
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $id)
    {
        $sensor = $this->sensor::with('sensor')->find($id);
        if(is_null($sensor)) {
            return response()->json(ApiError::errorMessage('sensor não encontrado.', 404), 404);
        }

        $data = ['data' => $sensor];
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
        $validator = Validator::make($id, $request->all(),[
            'nome' => 'required|string|min:2|max:100',
            'tipo' => 'in:temperatura, luminosidade, presenca, magnetico|required|min:8|max:12'
            ]);

        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }
        try {
            $sensordata = $request->all();
            $sensor = $this->sensor->find($id);

            if($sensor){
                $sensor->update($sensordata);
				$return = ['data' => ['msg' => 'sensor atualizado com sucesso.']];
				return response()->json($return, 201);
			}
			else{
				return response()->json(['data' => ['este sensor nao existe e nao pode ser atualizado']], 404);
			}

		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500),  500);
			}
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sensor $id)
    {
        $sensor = Sensor::find($id);
        try {
            if($sensor){
				$sensor->delete();
				return response()->json(['data' => ['msg' => 'sensor: '.$id->nome. ' deletado com sucesso.']], 200);
			}
			else{
				return response()->json(['data' => ['msg' => 'este sensor nao existe e nao pode ser deletado']], 500);
			}
		}catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500),  500);
			}
			return response()->json(ApiError::errorMessage('erro ao realizar operação de deletar', 500),  500);
		}
    
    }
}

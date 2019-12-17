<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $data = ['data' => $this->sensor::all()];
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
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|min:2|max:50',
            'tipo' => 'in:temperatura, luminosidade, presenca, magnetico|required|min:8|max:12'
        ]);
        
        if($validator->errors()){
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
			return response()->json(ApiError::errorMessage('erro ao realizar operação de salvar', 500),  500);
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
    	if(!$sensor) {
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
            'id' => 'required|number',
            'nome' => 'required|string|min:2|max:50',
            'tipo' => 'in:temperatura, luminosidade, presença, magnético|required|min:8|max:10'
            ]);

        try {
            $sensordata = $request->all();
            $sensor = $this->sensor->find($id);
            $sensor->update($sensordata);

			$return = ['data' => ['msg' => 'sensor atualizado com sucesso.']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500),  500);
			}
			return response()->json(ApiError::errorMessage('erro ao realizar operação de atualizar', 500), 500);
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
        try {
            
            $id->delete();
            return response()-> json(['data'=> ['msg'=> 'sensor: '.$id->nome. ' deletado com sucesso.']],200);

		}catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500),  500);
			}
			return response()->json(ApiError::errorMessage('erro ao realizar operação de deletar', 500),  500);
		}
    
    }
}
